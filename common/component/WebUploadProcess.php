<?php
/**
 * User: keven
 * Date: 2016/10/20
 * Time: 14:54
 */

namespace common\component;


use yii\helpers\VarDumper;

class WebUploadProcess
{
    const TARGET_DIR = 'targetDir'; //上传临时目录
    const UPLOADER_DIR = 'uploadDir';//上传总路径
    const MAX_FILE_AGE = 'maxFileAge';//文件最大生存期

    private $defaultConfig = [
        self::TARGET_DIR => 'upload_tmp',
        self::UPLOADER_DIR => 'uploads',
        self::MAX_FILE_AGE => 5*3600, //上传分片文件有效时间为5个小时

    ];//默认配置文件

    private $validConfig = [];//有效的配置文件
    private $shareItem = []; //处理过程中共有的项

    public function __construct(array $config=[])
    {
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        foreach ($this->defaultConfig as $key=>$value){
            $this->validConfig[$key] = $this->isConfigItemExists($config,$key)?$config[$key]:$this->defaultConfig[$key];
        }
        //分别创建临时上传目录和上传目录
        if(!file_exists($this->validConfig[self::TARGET_DIR])) @mkdir($this->validConfig[self::TARGET_DIR]);
        if(!file_exists($this->validConfig[self::UPLOADER_DIR])) @mkdir($this->validConfig[self::UPLOADER_DIR]);
    }

    /**
     * 检查配置项是否存在
     * @param array $config 待检查的配置项数组(存在,切不为空,则表示配置项存在)
     * @param string $item  待检查配置项
     * @return bool true表示存在,false表示不存在
     */
    private function isConfigItemExists(array $config,$item)
    {
        return isset($config[$item]) && !empty($config[$item]);
    }

    public  function init()
    {
        $request = $_REQUEST;
        $files = $_FILES;
        $this->getFileName($request,$files);//获取文件名称,以及上传文件目录
        $this->getChunkNum($request);//获取分片信息
        $this->removeOldTempFile();//删除旧的临时文件
        $this->openTempFile($files);
        $this->mergeFile();
    }

    /**
     * 根据分片总数,合并上传后的文件
     */
    protected function mergeFile(){
        $done = true;
        $chunks = $this->shareItem['chunks'];
        $filePath = $this->shareItem['filePath'];
        $uploadPath = $this->shareItem['uploadPath'];
        for( $index = 0; $index < $chunks; $index++ ) {
            if ( !file_exists("{$filePath}_{$index}.part") ) {
                $done = false;
                break;
            }
        }
        if ( $done ) {
            if (!$out = @fopen($uploadPath, "wb")) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
            }

            if ( flock($out, LOCK_EX) ) {
                for( $index = 0; $index < $chunks; $index++ ) {
                    if (!$in = @fopen("{$filePath}_{$index}.part", "rb")) {
                        break;
                    }

                    while ($buff = fread($in, 4096)) {
                        fwrite($out, $buff);
                    }

                    @fclose($in);
                    @unlink("{$filePath}_{$index}.part");
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
    protected function openTempFile($files){
        $filePath = $this->shareItem['filePath'];
        $chunk = $this->shareItem['chunk'];
        if (!$out = @fopen("{$filePath}_{$chunk}.parttmp", "wb")) {
            die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
        }

        if (!empty($files)) {
            VarDumper::dump($files,10,1);
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

        rename("{$filePath}_{$chunk}.parttmp", "{$filePath}_{$chunk}.part");
    }

    /**
     * 删除旧的文件(过期文件)
     * @param bool $cleanupTargetDir
     */
    protected function removeOldTempFile($cleanupTargetDir = true)
    {
        $targetDir = $this->validConfig[self::TARGET_DIR];
        VarDumper::dump($this->validConfig,10,1);
        VarDumper::dump($this->shareItem,10,1);
        if(!is_dir($targetDir) || !$dir = opendir($targetDir)){
            die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
        }
        $filePath = $this->shareItem['filePath'];
        $chunk = $this->shareItem['chunk'];
        $maxFileAge = $this->validConfig['maxFileAge'];
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

    /**
     * 获取文件上传时分片信息
     * chunk 表示第几个分片
     * chunks表示总共有多少个分片
     */
    protected function getChunkNum($request)
    {
        $this->shareItem['chunk'] = isset($request["chunk"]) ? intval($request["chunk"]) : 0;
        $this->shareItem['chunks'] = isset($request["chunks"]) ? intval($request["chunks"]) : 1;
    }

    /**
     * 获取文件名称
     * @param bool $isKeepOldName
     */
    protected function getFileName($request,$files,$isKeepOldName=false)
    {
        if(!$isKeepOldName){
            $this->shareItem['filename'] = md5(microtime()).md5(mt_rand(1,99));
        }else{
            //获取文件名
            if(isset($request['name'])){
                $this->shareItem['filename'] = $request['name'];
            }elseif (!empty($files['file']['name'])){
                $this->shareItem['filename'] = $files['file']['name'];
            }
            $this->shareItem['filename'] = uniqid('file_');
        }

        //上传文件临时路径
        $this->shareItem['filePath'] = $this->validConfig[self::TARGET_DIR] . DIRECTORY_SEPARATOR . $this->shareItem['filename'];
        //上传文件最终路径
        $this->shareItem['uploadPath'] = $this->validConfig[self::UPLOADER_DIR] . DIRECTORY_SEPARATOR . $this->shareItem['filename'];
    }
}