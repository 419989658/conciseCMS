<?php
/**
 * User: keven
 * Date: 2016/9/29
 * Time: 14:44
 */

namespace backend\models;

use yii\base\Model;
use yii\helpers\Url;

class TagForm extends Model
{
    public $tag_img;

    public function rules()
    {
        return [
            [['tag_img'], 'file', 'skipOnEmpty' => false, 'extensions' => 'jpg,png'],
        ];
    }

    public function upload()
    {
        if($this->validate()){
            $randName = date('Y').date('m').date('d').date('H').date('i').date('s').rand(111,999).md5(microtime());
            $uploadPath = 'uploads/'.$randName.'.'.$this->tag_img->extension;
            $this->tag_img->saveAs($uploadPath);
            return Url::to('advanced/web/'.$uploadPath,true);
        }else{
            return false;
        }
    }
}