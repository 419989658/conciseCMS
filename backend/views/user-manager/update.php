<?php
/**
 * User: keven
 * Date: 2016/10/24
 * Time: 9:35
 */
/* @var $model backend\models\AddUserForm */
use yii\bootstrap\ActiveForm;
$this->title = '批量修改用户名';
$this->params['breadcrumbs'][] = ['label'=>'用户管理中心','url'=>['index']];
$this->params['breadcurmbs'][] = $this->title;
?>
<?php $form = ActiveForm::begin();?>
<p>
    <div style="border:1px solid lightblue; margin:5px 0">
        <?= $form->field($model,'username')->input('text',['max']);?>
        <?= $form->field($model,'password_hash')->input('password');?>
        <?= $form->field($model,'email')->input('text');?>
    </div>

</p>

<?= \yii\bootstrap\Html::submitButton('修改用户信息',['class'=>'btn btn-success'])?>
<?php ActiveForm::end();?>