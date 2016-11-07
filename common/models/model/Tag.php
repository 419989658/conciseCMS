<?php
/**
 * User: keven
 * Date: 2016/11/7
 * Time: 11:48
 */

namespace common\models\model;


use yii\db\ActiveRecord;

class Tag extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%tag}}';
    }
}