<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\model\VideoInfo */
/* @var $uploadModel backend\models\ImageUpload */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="video-info-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <?php //echo $form->field($model, 'name')->textInput(['maxlength' => true]); ?>

    <?= $form->field($model, 'actor_id')->textInput() ?>

    <?= $form->field($model, 'tag_id')->textInput() ?>

    <?= $form->field($model, 'album_id')->textInput() ?>

    <?= $form->field($model, 'issue_date')->textInput() ?>

    <?= $form->field($model, 'play_time')->textInput() ?>

    <?= $form->field($uploadModel, 'coverImg')->fileInput(['multiple' => true, 'accept' => 'image/*'])->label('封面图片') ?>

    <?= $form->field($uploadModel, 'thumbImg')->fileInput(['multiple' => true, 'accept' => 'image/*'])->label('缩略图片') ?>

    <?= $form->field($uploadModel, 'videoFile')->fileInput(['multiple' => true, 'accept' => 'media/*'])->label('视频文件') ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
