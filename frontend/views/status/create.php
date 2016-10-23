<?php
/**
 * User: sometimes
 * Date: 2016/10/22
 * Time: 10:14
 */
/* @var $model frontend\models\StatusForm*/
$this->tilte = '提交新的信息';
$this->params['breadcrumbs'][] = ['label'=>'查看新的信息','url'=>['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<?php
    $form = \yii\widgets\ActiveForm::begin([
        'id'=>'form-status',
    ]);
?>

<?= $form->field($model,'text')->textarea(['row'=>15])->label('文字');  ?>
<?= $form->field($model,'permissions')->dropDownList($model->getSTATUS(),['style'=>'max-width:150px;']) ?>

<?=  \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-success']) ?>
<?php
    \yii\widgets\ActiveForm::end();
?>
