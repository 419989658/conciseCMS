<?php
/**
 * User: keven
 * Date: 2016/11/15
 * Time: 18:08
 */

namespace frontend\assets;


use yii\web\AssetBundle;

class CkPlayerAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    ];
    public $js = [
        'js/ckplayer6.8/ckplayer/ckplayer.js',
        'js/ckplayer6.8/myCkplayer.js',
    ];
    public $depends = [
    ];
}