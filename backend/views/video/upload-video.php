<?php
/**
 * User: keven
 * Date: 2016/10/25
 * Time: 11:18
 */
$this->title='上传视频';
$this->params['breadcrumbs'][] = ['label'=>'','url'=>['index']];
$this->params['breadcrumbs'][] = $this->title;

\backend\assets\WebUploaderAsset::register($this);
?>
<div id="uploader" class="wu-example">
    <!--用来存放文件信息-->
    <div id="thelist" class="uploader-list"></div>
    <div class="btns">
        <div id="picker">选择文件</div>
        <button id="ctlBtn1" class="btn btn-default">开始上传</button>
    </div>
</div>

<?php
$this->registerJs("
var 
    BASE_URL='',
    CHECK_CHUNK_SERVICE = UPLOAD_SERVICE = '".\yii\helpers\Url::toRoute(['progress-video'])."';


",\yii\web\View::POS_BEGIN);
?>


