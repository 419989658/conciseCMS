<?php
/**
 * User: sometimes
 * Date: 2016/10/1
 * Time: 19:22
 */

namespace backend\models;


use common\models\model\VideoInfo;
use yii\base\Model;
use yii\helpers\FileHelper;
use yii\helpers\VarDumper;
use yii\web\UploadedFile;

class VideoUpload extends Model
{
    public $coverImg;//封面图片  ->对应数据表中的 cover_img
    public $thumbImg;//缩略图    ->对应数据库中的 thumb_img

    //视频
    const ORIGIN_VIDEO_PATH = 'upload/video/origin/';   //原始视频文件
    const PLAY_VIDEO_PATH = 'upload/video/play/';       //可播放视频文件夹（经过转码后的视频）

    //图片
    const COVER_IMG_PATH = '/upload/cover/';             //封面图片目录
    const THUMB_IMG_PATH = '/upload/thumb/';             //缩略图片目录

    public $canEmpty = false;

    //枚举视频上传图片路径
    public static function  enumVideoUploadPath()
    {
        return [
            self::TYPE_COVER=>self::COVER_IMG_PATH,
            self::TYPE_THUMB=>self::THUMB_IMG_PATH,
        ];
    }

    const TYPE_COVER = 'cover';
    const TYPE_THUMB = 'thumb';

    private  static function enumVideoProperty()
    {
        return [
            self::TYPE_COVER => 'coverImg',
            self::TYPE_THUMB => 'thumbImg',
        ];
    }
    public function rules()
    {
        return [
            [['coverImg','thumbImg'],'file','skipOnEmpty' => $this->canEmpty],
        ];
    }


    public function upload($videoModel)
    {
        $videoModel->issue_date = strtotime($videoModel->issue_date);
        if($this->canEmpty) return true;
        $status = true;
        if ($this->validate()) {
            file_exists(self::COVER_IMG_PATH) ?: FileHelper::createDirectory(self::COVER_IMG_PATH);
            file_exists(self::THUMB_IMG_PATH) ?: FileHelper::createDirectory(self::THUMB_IMG_PATH);
            $uploadFiles = [];
            $baseName = date('YmdHis') . '_' . rand(111, 999) ;
            //保存上传文件列表
            $coverEx = explode('.',$this->coverImg->name);
            $thumbEx = explode('.',$this->thumbImg->name);
            $uploadFiles[self::TYPE_COVER] = $baseName . '_' . md5($this->coverImg->name).'.'.end($coverEx);
            $uploadFiles[self::TYPE_THUMB] = $baseName . '_' . md5($this->thumbImg->name).'.'.end($thumbEx);

            $videoUploadPath = self::enumVideoUploadPath();
            $videoProperty = self::enumVideoProperty();

            //对$coverImg和$thumbImg进行赋值,保存上传文件
            foreach ($uploadFiles as $key => $uploadFile) {
                $status = $this->$videoProperty[$key]->saveAs($videoUploadPath[$key] . $uploadFile);
                if(!$status){
                    return false;
                }
            }
            //对视频进行赋值
            $videoModel->cover_img = $uploadFiles[self::TYPE_COVER];
            $videoModel->thumb_img = $uploadFiles[self::TYPE_THUMB];

            //记录视频文件的名称
            $videoModel->name = isset($videoModel->name)?$videoModel->name:'未知';
            $videoModel->status = VideoInfo::STATUS_TRANS;
            return $status;
        }else{
            return false;
        }
    }

    /**
     * 删除所有文件，在失败回滚的时候使用
     */
    public function deleteAllUploadFiles()
    {
        if(isset($this->coverImg)) {
            unlink($this->coverImg);
        }
        if(isset($this->thumbImg)) {
            unlink($this->thumbImg);
        }

    }
}