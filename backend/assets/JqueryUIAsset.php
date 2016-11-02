<?php
/**
 * User: sometimes
 * Date: 2016/10/31
 * Time: 21:29
 */

namespace backend\assets;


use yii\web\AssetBundle;

class JqueryUIAsset extends AssetBundle
{
    public $basePath = '@app';
    public $baseUrl = '@web';
    public $css=[
    ];
    public $js = [
        'vendor/jqueryUI/jquery-ui.min.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}