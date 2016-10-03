<?php
/**
 * User: sometimes
 * Date: 2016/10/1
 * Time: 23:47
 */

namespace backend\models;

use yii\base\Model;
use yii\helpers\FileHelper;


class ImageUpload extends Model
{
    //private $imageFile;
    public $imageFile;

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png,jpg'],
        ];
    }

    /**
     * 用于上传图片
     * @param string $filePath 指定图片存放在何处，such as: path/to/image/,Note that:最后需要加上一个 /符号，表示存放目录
     * @return bool 上传成功返回 true,上传失败返回false
     */
    public function upload($filePath)
    {
        if(!file_exists($filePath)){
            FileHelper::createDirectory($filePath);
        }
        $fileName = date('YmdHis') . '_'
            . rand(111, 999) . '_' . md5($this->imageFile->baseName) . '.' . $this->imageFile->extension;
        if ($this->validate()) {
            $this->imageFile->saveAs($filePath.$fileName);
            return $filePath.$fileName;
        } else {
            return false;
        }
    }
}