<?php
/**
 * User: keven
 * Date: 2016/11/1
 * Time: 11:13
 */

namespace common\component;


class WebUploader1
{
    const STATUS_CHECK_FILE = 'checkFile';   //验证文件是否存在
    const STATUS_CHECK_CHUNK = 'checkChunk'; //验证分片是否存在
    const STATUS_UPLOAD = 'upload';          //上传文件

    const DIR_CHUNK = 'upload_tmp';
    const DIR_FILE = 'uploads';

    const FLAG_REMOVE_CHUNK = true; //是否删除分片文件
    const TMP_CHUNK_MAX_AGE = 5*3600; //分片文件最大生存时间

    private $request;
    private $files;
    private $hashMD5; // 文件MD5
    private $chunkFileDir;


    public function __construct(array $request, array $files)
    {
        $this->request = $request;
        $this->files = $files;

        //设置头信息
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        //创建上传目录
        if(!file_exists(self::DIR_CHUNK)) @mkdir(self::DIR_CHUNK);
        if(!file_exists(self::DIR_FILE)) @mkdir(self::DIR_FILE);
        //获取文件MD5
        $this->hashMD5 = isset($request['hashMD5'])?$request['hashMD5']:(string)$_COOKIE['file_md5'];
        //给每一个文件以[文件MD5]为文件夹,存放分片
        $chunkFileDir = $this->chunkFileDir = self::DIR_CHUNK.DIRECTORY_SEPARATOR.$this->hashMD5;
        if(!file_exists($chunkFileDir)) @mkdir($chunkFileDir);
        //判断请求的处理逻辑
        $uploadStatus = $request['status'];
        $this->switchStatus($uploadStatus);
    }

    public static function progress($request,$files)
    {
        return new WebUploader1($request,$files);
    }
    protected function switchStatus($status)
    {
        switch ($status){
            case self::STATUS_CHECK_FILE:   //检查文件是否存在
                break;
            case self::STATUS_CHECK_CHUNK:  //检查分片是否存在
                //配置分片具体路径
                //$chunkIndex = isset($this->request['chunkIndex'])?$this->request['chunkIndex']:0;
                $chunkIndex = $this->request['chunkIndex'];
                $chunkFilePath = $this->chunkFileDir.DIRECTORY_SEPARATOR.$this->hashMD5;
                $flag = $this->checkChunkExists($chunkFilePath,$chunkIndex);
                if($flag){
                    $fileSuffix = $this->request['type'];
                    $this->mergeFile($chunkFilePath,$fileSuffix,true);  //合并文件
                    die('{"ifExist":1}');
                }
               // echo '---'.$flag;
                die('{"ifExist":0}');
                break;
            case self::STATUS_UPLOAD:       //上传文件
                if(self::FLAG_REMOVE_CHUNK){
                    //TODO 删除过期的分片
                }
                $fileType = $this->request['type'];
                $fileSuffix = explode('/',$fileType)[1];
                $chunkIndex = isset($this->request['chunk'])?$this->request['chunk']:0;
                $chunkFilePath = $this->chunkFileDir.DIRECTORY_SEPARATOR.$this->hashMD5;
                $this->openTempFile($chunkFilePath,$chunkIndex);
               // $this->removeOldTempFile($this->chunkFileDir,$chunkFilePath); //删除原有的旧文件
                $this->mergeFile($chunkFilePath,$fileSuffix);  //合并文件
                break;
        }
    }
    protected function mergeFile($chunkFilePath,$fileSuffix,$flag=false){
        $done = true;
        $chunks = $this->request['chunks'];
        $filePath = self::DIR_FILE . DIRECTORY_SEPARATOR.$this->hashMD5.'.'.$fileSuffix;
        for( $index = 0; $index < $chunks; $index++ ) {
            if ( !file_exists("{$chunkFilePath}_{$index}.part") ) {
                $done = false;
              //  echo '123123123123'."{$chunkFilePath}_{$index}.part";
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
            @rmdir($this->chunkFileDir);        //删除分片文件夹
        }
        // Return Success JSON-RPC response
        if(!$flag){
            die('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');
        }
    }

    /**
     * 打开上传的临时文件,检查其正确性
     */
    protected function openTempFile($chunkFilePath,$chunkIndex){
        $files = $this->files;
        if (!$out = @fopen("{$chunkFilePath}_{$chunkIndex}.parttmp", "wb")) {
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

        rename("{$chunkFilePath}_{$chunkIndex}.parttmp",  "{$chunkFilePath}_{$chunkIndex}.part");
    }

    /**
     * 基于文件夹的最后修改时间,删除老的文件
     * @param $targetDir
     */
    public function removeOldTempFile($targetDir,$curChunk)
    {
        if (!is_dir($targetDir) || !$dir = opendir($targetDir)) {
            die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
        }
        while (($file = readdir($dir)) !== false) {
            $tmpFilePath = $targetDir . DIRECTORY_SEPARATOR .$file;
            if ($tmpFilePath == "$curChunk.part" || $tmpFilePath == "$curChunk.parttmp") {
                continue;
            }

            // Remove temp file if it is older than the max age and is not the current file
            if (preg_match('/\.(part|parttmp)$/', $file) && (@filemtime($curChunk) < time() - self::TMP_CHUNK_MAX_AGE)) {
                @unlink($tmpFilePath);
            }
        }
        closedir($dir);
    }
    /**
     * 检查分片 true表示存在 false 表示不存在
     * @param $chunkFilePath
     * @return bool
     */
    protected function checkChunkExists($chunkFilePath,$chunkIndex)
    {
        $target = $chunkFilePath.'_'.$chunkIndex.'.part';
        return (file_exists($target) && (filesize($target) == $this->request['size']))?true:false;
    }
}