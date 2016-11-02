<?php
/**
 * User: keven
 * Date: 2016/10/24
 * Time: 9:54
 */
use \yii\helpers\Url;
$this->title='用户管理中心';
$this->params['breadcrumbs'][] = $this->title;
?>

<?= \yii\bootstrap\Html::a('批量添加用户',['user-manager/create'],['class'=>'btn btn-success']); ?>

<?= \yii\grid\GridView::widget([
    'dataProvider'=>$dataProvider,
    'filterModel'=>$searchModel,
    "options" => ["class" => "grid-view","style"=>"overflow:auto", "id" => "grid"],
    'columns'=>[
        [
            "class" => "yii\grid\CheckboxColumn",
            "name" => "id",
        ],
        ['class'=>'yii\grid\SerialColumn'],
        'username',
        'email',
        ['class'=>'yii\grid\ActionColumn'],
    ],
]);?>

<?php
echo \yii\bootstrap\Html::a('批量删除','###',['class'=>'btn btn-success batch-del-content']);
$batchDel = Url::toRoute('batch-del-user');
$this->registerJs('
$(document).on("click", ".batch-del-content", function () {
    var keys = $("#grid").yiiGridView("getSelectedRows");
    if (keys.length ==0)
    {
        alert(\'您还没有选择要删除的作品\');
        return;
    }
    $.post("'.$batchDel.'&ids="+keys); 
});
');
?>