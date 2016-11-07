<?php
/**
 * User: keven
 * Date: 2016/11/7
 * Time: 10:59
 */

namespace app\models;


use yii\db\ActiveRecord;

class Test extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%test}}';
    }
}