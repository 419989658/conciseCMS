<?php
/**
 * User: sometimes
 * Date: 2016/10/2
 * Time: 0:27
 */

namespace common\component;


use backend\models\ImageUpload;
use backend\models\UploadConfig;
use backend\models\VideoUpload;
use common\models\model\VideoInfo;
use yii\helpers\VarDumper;
use yii\web\UploadedFile;

class VideoComponent
{
    /**
     * 返回视频上传相关模型
     * @return
     */
    public function getVideoUpload()
    {
        return new VideoUpload();
    }

    /**
     * 返回电影上传模型
     * @return VideoInfo
     */
    public function getVideoModel()
    {
         return  new VideoInfo();
    }
    /**
     * 上传电影相关文件
     * @param array $models getVideoModel返回的数组，分别为 封面图片，缩略图，视频文件的上传模型
     * @return array
     */
    public function upload($videoModel,$uploadModel){
        $uploadStatus = true;

        $uploadModel->videoFile = UploadedFile::getInstance($uploadModel,'videoFile');
        $uploadModel->coverImg = UploadedFile::getInstance($uploadModel,'coverImg');
        $uploadModel->thumbImg = UploadedFile::getInstance($uploadModel,'thumbImg');

        if($uploadFiles = $uploadModel->upload()){
            //记录三张图片的URL地址
            $videoModel->cover_img = $uploadFiles[UploadConfig::TYPE_COVER];
            $videoModel->thumb_img = $uploadFiles[UploadConfig::TYPE_THUMB];
            $videoModel->origin_url = $uploadFiles[UploadConfig::TYPE_VIDEO];
            //记录视频文件的名称
            $videoModel->name = $uploadModel->videoFile->baseName;
        }

        if($uploadStatus){
           return $videoModel;
        }else{
            //TODO上传失败后的处理
        }

    }
}