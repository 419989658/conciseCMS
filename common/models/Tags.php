<?php

namespace common\models;

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

    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tag'], 'required'],
            [['tag', 'meta_description', 'tag_img'], 'string', 'max' => 255],
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
            'meta_description' => 'Meta Description',
            'tag_img' => 'Tag Img',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    public function getPost(){
        return $this->hasMany(Posts::className(),['id'=>'post_id'])
            ->viaTable(PostTagPivot::tableName(),['tag_id'=>'id'])
            ->where(['status'=>1]);
    }
}
