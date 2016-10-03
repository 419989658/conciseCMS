<?php

namespace common\models\model;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%video_info}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $actor_id
 * @property integer $tag_id
 * @property integer $album_id
 * @property integer $issue_date
 * @property integer $play_time
 * @property string $cover_img
 * @property string $thumb_img
 * @property string $play_url
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class VideoInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%video_info}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'actor_id', 'tag_id', 'album_id'], 'required'],
            [['actor_id', 'tag_id', 'album_id', 'issue_date', 'play_time', 'status'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['cover_img', 'thumb_img', 'play_url','origin_url'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '电影名称',
            'actor_id' => '演员表ID',
            'tag_id' => '标签表ID',
            'album_id' => '专辑表ID',
            'issue_date' => '发行日期',
            'play_time' => '播放时长',
            'cover_img' => '封面图片',
            'thumb_img' => '缩略图',
            'origin_url' => '视频原始地址',
            'play_url' => '播放地址',
            'status' => '状态',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
        ];
    }
}
