<?php
/**
 * User: keven
 * Date: 2016/10/20
 * Time: 14:54
 */

namespace common\component;

/**
 * Class WebUploadProcess 包装操作
 *
 *  1.断点续传
 *      后台验证
 * Note that:一个完整文件,是由若干个分片文件组合而成
 * @package common\component
 */
class WebUploader
{
    const STATUS_CHECK_FILE = 'checkFile';   //验证文件是否存在
    const STATUS_CHECK_CHUNK = 'checkChunk'; //验证分片是否存在
    const STATUS_UPLOAD = 'upload';          //上传文件

    //默认配置文件
    private $config = [
        'chunkDir' => 'upload_tmp',    //上传临时目录
        'fileDir' => 'uploads',       //上传总路径
        'maxFileAge' => 5*3600,         //上传分片文件有效时间为5个小时
    ];
    private $shareItem = [
        'fileInfo'=>[
            'filename'=>[
                'old'=>''
                ,'new'=>''
            ]
            ,'fileSize'=>''
            ,'suffix'=>''
            ,'hashMD5'=>''
        ]
        ,'chunkInfo'=>[
            'chunk'=>0             //表示第几个分片
            ,'chunks'=>1             //表示总共有多少个分片
        ]
        ,'chunkFileDir'=>''         //分片文件所在的目录
        ,'chunkFilePath'=>''         //分片文件文件临时路径
        ,'filePath'=>''             //上传文件最终路径
    ]; //处理过程中共有的项

    //保存前台POST过来的数据
    private $request;
    private $files;

    /**
     * 初始化WebUploader后端处理服务,区分前端JS的具体工作
     *      1.设定服务端返回头信息
     *
     *      2.验证请求类型:
     *            >验证整体文件是否存在 秒传功能
     *            >验证文件分片是否存在 断点续传功能
     *            >上传分片文件
     *      3.初始化处理程序配置
     * WebUploadProcess constructor.
     * @param $request
     * @param array $config
     */
    public function __construct($request,$files,array $config=[])
    {
        $this->request = $request;
        $this->files = $files;
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        if(!empty($config)){
            array_merge($this->config,$config);
        }
        $chunkDir = $this->config['chunkDir'];
        $fileDir = $this->config['fileDir'];
        if(!file_exists($chunkDir)) @mkdir($chunkDir);
        if(!file_exists($fileDir)) @mkdir($fileDir);
        //接受该文件的MD5值
        $md5 = $this->shareItem['fileInfo']['hashMD5']
            = isset($request['chunkMD5'])?$request['chunkMD5']:(string)$_COOKIE['file_md5'];
        //分片保存的目录
        $chunkFileDir = $this->shareItem['chunkFileDir']
            = $this->config['chunkDir'].DIRECTORY_SEPARATOR.$md5;
        if(!file_exists($chunkFileDir)) @mkdir($chunkFileDir);
        //分片文件路径
        $this->shareItem['chunkFilePath'] = $chunkFileDir.DIRECTORY_SEPARATOR.$md5;
        $this->shareItem['filePath'] = $this->config['fileDir'].DIRECTORY_SEPARATOR.$md5;

        //判断请求的处理逻辑
        $uploadStatus = $request['status'];
        $this->switchStatus($uploadStatus);
    }

    public static function progress($request,$config=[])
    {
        return new WebUploader($request,$config);
    }


    private function switchStatus($status)
    {
        switch ($status){
            case self::STATUS_CHECK_FILE:   //检查文件是否存在
                break;
            case self::STATUS_CHECK_CHUNK:  //检查分片是否存在
                $this->shareItem['chunkInfo']['chunk'] = $this->request['chunkIndex'];
                $this->chunkCheck();
                break;
            case self::STATUS_UPLOAD:       //上传文件
                $this->openTempFile();
                $this->mergeFile();
                break;
        }
    }
    /**
     * 根据分片总数,合并上传后的文件
     */
    protected function mergeFile(){
        $done = true;
        $chunks = $this->shareItem['chunkInfo']['chunks'];
        $filePath = $this->shareItem['filePath'];
        $chunkFilePath = $this->shareItem['chunkFilePath'];

        for( $index = 0; $index < $chunks; $index++ ) {
            if ( !file_exists("{$chunkFilePath}_{$index}.part") ) {
                $done = false;
                break;
            }
        }
        if ( $done ) {
            if (!$out = @fopen($filePath, "wb")) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
            }

            if ( flock($out, LOCK_EX) ) {
                for( $index = 0; $index < $chunks; $index++ ) {
                    if (!$in = @fopen("{$chunkFilePath}_{$index}.part", "rb")) {
                        break;
                    }

                    while ($buff = fread($in, 4096)) {
                        fwrite($out, $buff);
                    }

                    @fclose($in);
                    @unlink("{$chunkFilePath}_{$index}.part");
                }

                flock($out, LOCK_UN);
            }
            @fclose($out);
        }
        // Return Success JSON-RPC response
        die('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');
    }

    /**
     * 打开上传的临时文件,检查其正确性
     */
    protected function openTempFile(){
        $files = $this->files;
        $chunkFileDir = $this->shareItem['chunkFileDir'];
        $chunkFilePath = $chunkFileDir.DIRECTORY_SEPARATOR.$this->shareItem['fileInfo']['hashMD5'];
        $chunk = $this->shareItem['chunkInfo']['chunk'];
        if (!$out = @fopen("{$chunkFilePath}_{$chunk}.parttmp", "wb")) {
            die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
        }

        if (!empty($files)) {
            if ($files["file"]["error"] || !is_uploaded_file($files["file"]["tmp_name"])) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
            }

            // Read binary input stream and append it to temp file
            if (!$in = @fopen($files["file"]["tmp_name"], "rb")) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
            }
        } else {
            if (!$in = @fopen("php://input", "rb")) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
            }
        }

        while ($buff = fread($in, 4096)) {
            fwrite($out, $buff);
        }

        @fclose($out);
        @fclose($in);

        rename("{$chunkFilePath}_{$chunk}.parttmp", "$chunkFilePath");
    }

    /**
     * 删除旧的文件(过期文件)
     * @param bool $cleanupTargetDir
     */
    protected function removeOldTempFile($cleanupTargetDir = true)
    {
        $targetDir = $this->validConfig[self::TARGET_DIR];
        if(!is_dir($targetDir) || !$dir = opendir($targetDir)){
            die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
        }
        $filePath = $this->shareItem['filePath'];
        $chunk = $this->shareItem['chunk'];
        $maxFileAge = $this->validConfig[self::MAX_FILE_AGE];
        while (($file = readdir($dir)) !== false) {
            $tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;
            if ($tmpfilePath == "{$filePath}_{$chunk}.part" || $tmpfilePath == "{$filePath}_{$chunk}.parttmp") {
                continue;
            }
            // Remove temp file if it is older than the max age and is not the current file
            if (preg_match('/\.(part|parttmp)$/', $file) && (@filemtime($tmpfilePath) < time() - $maxFileAge)) {
                @unlink($tmpfilePath);
            }
        }
        closedir($dir);
    }

    protected function chunkCheck()
    {
        $target = $this->shareItem['chunkFilePath'];
        if(file_exists($target) && filesize($target) == $this->request['size']){
            die('{"ifExist":1}');
        }
        die('{"ifExist":0}');
    }

    /**
     * 获取文件上传时分片信息
     * chunk 表示第几个分片
     * chunks表示总共有多少个分片
     */
    protected function setChunkInfo()
    {
        $chunk = $this->shareItem['chunkInfo']['chunk'] = isset($request["chunk"]) ? intval($request["chunk"]) : 0;
        $this->shareItem['chunkInfo']['chunks'] = isset($request["chunks"]) ? intval($request["chunks"]) : 1;
        $chunkIndex = isset($this->request['chunkIndex'])?$this->request['chunkIndex']:$chunk;
        $chunkFilePath = $this->shareItem['chunkFilePath'];
        $this->shareItem['chunkFilePathPart'] = "{$chunkFilePath}_{$chunkIndex}.part";
    }


}



