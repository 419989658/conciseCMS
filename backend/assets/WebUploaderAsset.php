<?php
/**
 * User: keven
 * Date: 2016/10/19
 * Time: 15:41
 */

namespace backend\assets;


use yii\web\AssetBundle;

class WebUploaderAsset extends AssetBundle
{
    public $basePath = '@app';
    public $baseUrl = '@web';
    public $css=[
        'css/webuploader.css',
    ];
    public $js = [
        'js/webuploader.min.js',
        'js/mywebuploader.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}