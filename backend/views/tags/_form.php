<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Tags */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tags-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'tag')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($uploadImg, 'tag_img')->fileInput()?>
    <div id="uploader" class="wu-example eye-protector-processed" style="transition: background 0.3s ease; background-color: rgb(193, 230, 198); border-color: rgba(0, 0, 0, 0.34902); border-top-style: dashed; border-bottom-style: dashed;">
        <div class="queueList eye-protector-processed" style="border-color: rgba(0, 0, 0, 0.34902);">
            <div id="dndArea" class="placeholder eye-protector-processed" style="border-color: rgba(0, 0, 0, 0.34902);">
                <div id="filePicker" class="webuploader-container eye-protector-processed" style="border-color: rgba(0, 0, 0, 0.34902); color: rgb(0, 0, 0);"><div class="webuploader-pick">点击选择图片</div><div id="rt_rt_1atqkb80910rqd8556e1f84167e1" style="position: absolute; top: 0px; left: 448px; width: 168px; height: 44px; overflow: hidden; bottom: auto; right: auto;"><input type="file" name="file" class="webuploader-element-invisible" multiple="multiple" accept="image/*"><label class="eye-protector-processed" style="opacity: 0; width: 100%; height: 100%; display: block; cursor: pointer; background: rgb(193, 230, 198); transition: background 0.3s ease;"></label></div></div>
                <p class="eye-protector-processed" style="border-color: rgba(0, 0, 0, 0.34902); color: rgb(0, 0, 0);">或将照片拖到这里，单次最多可选300张</p>
            </div>
            <ul class="filelist"></ul></div>
        <div class="statusBar eye-protector-processed" style="display: none; border-top-color: rgba(0, 0, 0, 0.34902); border-top-style: dashed;">
            <div class="progress eye-protector-processed" style="display: none; transition: background 0.3s ease; background-color: rgb(193, 230, 198); color: rgb(0, 0, 0);">
                <span class="text">0%</span>
                <span class="percentage" style="width: 0%;"></span>
            </div><div class="info">共0张（0B），已上传0张</div>
            <div class="btns">
                <div id="filePicker2" class="webuploader-container"><div class="webuploader-pick eye-protector-processed" style="transition: background 0.3s ease; background-color: rgb(193, 230, 198); border-color: rgba(0, 0, 0, 0.34902); border-style: dashed;">继续添加</div><div id="rt_rt_1atqkb80eav25je1s5q1201bvg6" style="position: absolute; top: 0px; left: 0px; width: 1px; height: 1px; overflow: hidden;"><input type="file" name="file" class="webuploader-element-invisible" multiple="multiple" accept="image/*"><label class="eye-protector-processed" style="opacity: 0; width: 100%; height: 100%; display: block; cursor: pointer; background: rgb(193, 230, 198); transition: background 0.3s ease;"></label></div></div><div class="uploadBtn state-pedding">开始上传</div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
