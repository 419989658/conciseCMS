<?php

namespace common\models\model;

use Yii;

/**
 * This is the model class for table "{{%tag}}".
 *
 * @property string $id
 * @property string $name
 *
 * @property ActorTagPivot[] $actorTagPivots
 * @property VideoTagPivot[] $videoTagPivots
 */
class Tag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tag}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '标签名称',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActorTagPivots()
    {
        return $this->hasMany(ActorTagPivot::className(), ['tag_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVideoTagPivots()
    {
        return $this->hasMany(VideoTagPivot::className(), ['tag_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \common\models\query\TagQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\TagQuery(get_called_class());
    }
}
