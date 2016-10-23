<?php
/**
 * User: sometimes
 * Date: 2016/10/22
 * Time: 10:09
 */

namespace frontend\models;


use yii\base\Model;

class StatusForm extends Model
{

    const STATUS_PUBLIC = 10;
    const STATUS_PRIVATE = 20;
    public $text;
    public $permissions;

    public function rules()
    {
        return
        [
            [['text','permissions'],'required'],
            [['text'],'string'],
        ];

    }

    public function getSTATUS()
    {
        return [
            self::STATUS_PRIVATE => '私有',
            self::STATUS_PUBLIC => '共有',
        ];
    }

    public function getStatusLabel($status)
    {
        switch ($status){
            case self::STATUS_PRIVATE:
                return '私有';
        }
    }

}