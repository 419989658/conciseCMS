<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\model\VideoInfo */
/* @var $uploadModel backend\models\ImageUpload */
/* @var $form yii\widgets\ActiveForm */
\backend\assets\WebUploaderAsset::register($this);
?>
<div class="video-info-form">
    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'],
        'enableAjaxValidation' => true,
    ]); ?>
    <?php //echo $form->field($model, 'name')->textInput(['maxlength' => true]); ?>

    <?= $form->field($model, 'actor_id')->textInput() ?>

    <?= $form->field($model, 'tag_id')->textInput() ?>

    <?= $form->field($model, 'album_id')->textInput() ?>

    <?= $form->field($model, 'issue_date')->textInput() ?>

    <?= $form->field($model, 'play_time')->textInput() ?>

    <?= $form->field($uploadModel, 'coverImg')->fileInput(['multiple' => true, 'accept' => 'image/*'])->label('封面图片') ?>

    <?= $form->field($uploadModel, 'thumbImg')->fileInput(['multiple' => true, 'accept' => 'image/*'])->label('缩略图片') ?>

    <?= $form->field($uploadModel, 'videoFile')->fileInput(['multiple' => true, 'accept' => 'media/*'])->label('视频文件') ?>

    <div id="uploader" class="wu-example">
        <!--用来存放文件信息-->
        <div id="thelist" class="uploader-list"></div>
        <div class="btns">
            <div id="picker">选择文件</div>
            <button id="ctlBtn1" class="btn btn-default">开始上传</button>
        </div>
    </div>

    <?= $form->field($model, 'status')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['id'=>'ctlBtn','class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$this->registerJs("
var 
    BASE_URL='',
    CHECK_CHUNK_SERVICE = UPLOAD_SERVICE = '".\yii\helpers\Url::toRoute(['upload-video'])."';


",\yii\web\View::POS_BEGIN);
?>