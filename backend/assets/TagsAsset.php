<?php
/**
 * User: sometimes
 * Date: 2016/10/31
 * Time: 20:30
 */

namespace backend\assets;


use yii\web\AssetBundle;

class TagsAsset extends AssetBundle
{
    public $basePath = '@app';
    public $baseUrl = '@web';
    public $css=[
        'vendor/tags/css/jquery.tagsinput.css',
    ];
    public $js = [
        'vendor/tags/js/jquery.tagsinput.min.js',
        'vendor/tags/myTags.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'backend\assets\JqueryUIAsset'
    ];
}