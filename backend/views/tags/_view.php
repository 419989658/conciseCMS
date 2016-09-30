<?php
/*@var $this yii\web\View*/
/*@var $model common\models\Tags*/

?>


<h2><?= \yii\helpers\Html::encode($model->tag.' : '.$model->meta_description)?></h2>
<?= \yii\widgets\DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'tag',
        'meta_description',
        'tag_img',
        'created_at:datetime',
        'updated_at',
    ],
]) ?>