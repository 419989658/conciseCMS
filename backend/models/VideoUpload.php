<?php
/**
 * User: sometimes
 * Date: 2016/10/1
 * Time: 19:22
 */

namespace backend\models;


use yii\base\Model;
use yii\helpers\FileHelper;
use yii\helpers\VarDumper;

class VideoUpload extends Model
{
    public $coverImg;//封面图片  ->对应数据表中的 cover_img
    public $thumbImg;//缩略图    ->对应数据库中的 thumb_img

    private  function enumVideoProperty()
    {
        return [
            UploadConfig::TYPE_COVER => 'coverImg',
            UploadConfig::TYPE_THUMB => 'thumbImg',
        ];
    }
    public function rules()
    {
        return [
            [['coverImg','thumbImg'], 'file', 'skipOnEmpty' => false, 'extensions' => 'jpg,png'],
        ];
    }

    /**
     * 视频存放位置
     * @param string $filePath 指定图片存放在何处，such as: path/to/image/,Note that:最后需要加上一个 /符号，表示存放目录
     * @return bool | array 上传成功返回文件的名字集合,上传失败返回false
     */
    public function upload()
    {
        file_exists(UploadConfig::COVER_IMG_PATH) ?: FileHelper::createDirectory(UploadConfig::COVER_IMG_PATH);
        file_exists(UploadConfig::THUMB_IMG_PATH) ?: FileHelper::createDirectory(UploadConfig::THUMB_IMG_PATH);

        if ($this->validate()) {
            $uploadFiles = [];
            $baseName = date('YmdHis') . '_' . rand(111, 999) . '_';
            $uploadFiles[UploadConfig::TYPE_COVER] = $baseName . md5($this->coverImg->baseName) . '.' . $this->coverImg->extension;
            $uploadFiles[UploadConfig::TYPE_THUMB] = $baseName . md5($this->thumbImg->baseName) . '.' . $this->thumbImg->extension;

            $videoUploadPath = UploadConfig::enumVideoUploadPath();
            $videoProperty = $this->enumVideoProperty();
            foreach ($uploadFiles as $key => $uploadFile) {
                $this->$videoProperty[$key]->saveAs($videoUploadPath[$key] . $uploadFile);
            }
            return $uploadFiles;
        } else {
            //验证失败，TODO
            return false;
        }
    }


}