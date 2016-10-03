<?php
/**
 * User: sometimes
 * Date: 2016/10/2
 * Time: 0:10
 */

namespace backend\models;


class UploadConfig
{
    //图片
    const COVER_IMG_PATH = 'upload/cover/';             //封面图片目录
    const THUMB_IMG_PATH = 'upload/thumb/';             //缩略图片目录

    //视频
    const ORIGIN_VIDEO_PATH = 'upload/video/origin/';   //原始视频文件
    const PLAY_VIDEO_PATH = 'upload/video/play/';       //可播放视频文件夹（经过转码后的视频）

    //电影上传名称

    const TYPE_COVER = 'cover';
    const TYPE_THUMB = 'thumb';
    const TYPE_VIDEO = 'video';

    //枚举视频上传文件路径
    public static function  enumVideoUploadPath()
    {
        return [
            self::TYPE_COVER=>self::COVER_IMG_PATH,
            self::TYPE_THUMB=>self::THUMB_IMG_PATH,
            self::TYPE_VIDEO=>self::ORIGIN_VIDEO_PATH,
        ];
    }
}