<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%post_tag_pivot}}".
 *
 * @property integer $id
 * @property string $post_id
 * @property string $tag_id
 */
class PostTagPivot extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%post_tag_pivot}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id', 'tag_id'], 'required'],
            [['post_id', 'tag_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'post_id' => 'Post ID',
            'tag_id' => 'Tag ID',
        ];
    }
}
