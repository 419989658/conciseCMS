<?php

namespace common\models\model;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%tags}}".
 *
 * @property integer $id
 * @property string $tag
 * @property string $meta_description
 * @property string $tag_img
 * @property integer $created_at
 * @property integer $updated_at
 */
class Tags extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tags}}';
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tag'], 'required'],
            [['tag'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tag' => 'Tag',
        ];
    }
    public function getPost(){
        return $this->hasMany(Posts::className(),['id'=>'post_id'])
            ->viaTable(PostTagPivot::tableName(),['tag_id'=>'id'])
            ->where(['status'=>1]);
    }
    public function getVideo()
    {
        //return $this->hasMany()
    }
}
