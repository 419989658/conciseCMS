<?php

namespace common\models\model;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%video_info}}".
 *
 * @property integer $id
 * @property string $name
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
    const STATUS_NORMAL = 0;
    const STATUS_TRANS = 1;     //转码中
    const STATUS_FAIL = 2;      //失败

    public $tags;

    public static function tableName()
    {
        return '{{%video_info}}';
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'created_at',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'updated_at',
                ],
                'value' => function () {
                    return date('U'); // unix timestamp },
                }
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['issue_date','origin_url'], 'required'],
            [['play_time', 'status'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['cover_img', 'thumb_img', 'play_url', 'origin_url'], 'string', 'max' => 255]
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

    public static function enumStatus()
    {
        return [
            self::STATUS_NORMAL => '正常',
            self::STATUS_TRANS => '转码中',
            self::STATUS_FAIL => '转码失败'
        ];
    }

    public static function getStatus($status)
    {
        switch ($status) {
            case self::STATUS_NORMAL:
                return '正常';
            case self::STATUS_TRANS:
                return '转码中';
            case self::STATUS_FAIL:
                return '转码失败';
            default:
        }
        return '未知状态';
    }
}
