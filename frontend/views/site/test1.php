<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Tags */
/* @var $form ActiveForm */
?>
<div class="site-test1">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'tag') ?>
        <?= $form->field($model, 'meta_description') ?>
        <?= $form->field($model, 'tag_img') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- site-test1 -->
