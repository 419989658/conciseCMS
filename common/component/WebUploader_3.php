<?php
/**
 * User: keven
 * Date: 2016/11/2
 * Time: 10:46
 */

namespace common\component;


class WebUploader_3
{
    private $request;
    private $files;

    const DIR_CHUNK = 'upload_tmp';
    const DIR_FILE = 'uploads';

    const STATUS_CHECK_FILE = 'checkFile';   //验证文件是否存在
    const STATUS_CHECK_CHUNK = 'checkChunk'; //验证分片是否存在
    const STATUS_UPLOAD = 'upload';          //上传文件
    const STATUS_UNKNOWN = 'unknown';       //未知状态

    const FLAG_REMOVE_CHUNK = true; //是否删除分片文件
    const TMP_CHUNK_MAX_AGE = 36000; //分片文件最大生存时间

    private $hashMD5; // 文件MD5
    private $chunkFileDir;
    private $status;
    private $fileSuffix; // 获取文件后缀
    public function __construct($request,$files)
    {
        $this->request = $request;
        $this->files = $files;
        //设置头信息
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        $this->createDir(self::DIR_CHUNK);
        $this->createDir(self::DIR_FILE);

        //获取文件MD5
        $this->hashMD5 = isset($request['hashMD5'])?$request['hashMD5']:(string)$_COOKIE['file_md5'];
        //给每一个文件以[文件MD5]为文件夹,存放分片
        $chunkFileDir = $this->chunkFileDir = self::DIR_CHUNK.DIRECTORY_SEPARATOR.$this->hashMD5;
        $this->createDir($chunkFileDir);
        //获取当前服务器处理状态
        $this->status = isset($request['status'])?$request['status']:self::STATUS_UNKNOWN;
        $this->status = in_array($request['status'],WebUploader_3::progressStatus())?$request['status']:self::STATUS_UNKNOWN;
        $this->fileSuffix = $this->request['type'];
    }

    /**
     * 返回一个WebUploader实例
     * @param $request
     * @param $files
     * @return WebUploader_3
     */
    public static function init($request,$files){
        return new WebUploader_3($request,$files);
    }

    /**
     *  返回处理状态
     * @return array
     */
    public static function progressStatus()
    {
        return [
            self::STATUS_CHECK_FILE,
            self::STATUS_CHECK_CHUNK,
            self::STATUS_UPLOAD,
            self::STATUS_UNKNOWN,
        ];
    }

    /**
     * 程序处理入口函数
     */
    public function progress()
    {
        $curStatus = $this->status;
        switch ($curStatus){
            case self::STATUS_CHECK_FILE:   //检查文件是否存在
                break;
            case self::STATUS_CHECK_CHUNK:  //检查分片是否存在
                $chunkIndex = $this->request['chunkIndex'];
                $chunkFilePath = $this->chunkFileDir.DIRECTORY_SEPARATOR.$this->hashMD5;
                $curChunkExists = $this->checkChunkExists($chunkFilePath,$chunkIndex);
                //最后一个分片
                $isLastChunk = ($this->request['chunkIndex']+1) == $this->request['chunks'];
                if($isLastChunk && $curChunkExists){
                    $this->mergeFile($chunkFilePath,$this->fileSuffix);
                }
                if($curChunkExists){
                    die('{"ifExist":1}');
                }
                die('{"ifExist":0}');
                break;
            case self::STATUS_UPLOAD:
                if(self::FLAG_REMOVE_CHUNK){
                    //TODO 删除过期的分片
                    // $this->removeOldTempFile($this->chunkFileDir,$chunkFilePath); //删除原有的旧文件
                }
                $fileType = $this->fileSuffix;
                $fileSuffix = explode('/',$fileType)[1];
                $chunkIndex = isset($this->request['chunk'])?$this->request['chunk']:0;
                $chunkFilePath = $this->chunkFileDir.DIRECTORY_SEPARATOR.$this->hashMD5;
                $this->openTempFile($chunkFilePath,$chunkIndex);
                if($this->isFullChunks($chunkFilePath)){
                    $this->mergeFile($chunkFilePath,$fileSuffix);  //合并文件
                }
                //上传分片完毕
                die('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');
                break;
            case self::STATUS_UNKNOWN:
                break;
            default:

        }
    }

    public function jsonRpc()
    {
        die('{"jsonrpc"}');
    }

    /**
     * 根据文件路径创建文件夹
     * @param $dirPath
     */
    private function createDir($dirPath)
    {
        if(!file_exists($dirPath)) @mkdir($dirPath);
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

    /**
     * 判断所有分片是否都存在
     * @param $chunkFilePath
     * @return bool
     */
    public function isFullChunks($chunkFilePath)
    {
        $chunks = $this->request['chunks'];
        for( $index = 0; $index < $chunks; $index++ ) {
            if ( !file_exists("{$chunkFilePath}_{$index}.part") ) {
                return false;
            }
        }
        return true;
    }

    /**
     *  合并所有分片文件
     * @param $chunkFilePath
     * @param $fileSuffix
     */
    protected function mergeFile($chunkFilePath,$fileSuffix){
        $chunks = $this->request['chunks'];
        $filePath = self::DIR_FILE . DIRECTORY_SEPARATOR.$this->hashMD5.'.'.$fileSuffix;
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
                    //删除当前分片
                 //   @unlink("{$chunkFilePath}_{$index}.part");
                }
                flock($out, LOCK_UN);
            }
            @fclose($out);
            @rmdir($this->chunkFileDir);        //删除分片文件夹
        // Return Success JSON-RPC response
        die('{"jsonrpc" : "2.0", "result" : "'.addslashes($filePath).'", "id" : "id"}');
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

}