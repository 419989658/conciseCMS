<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\model\VideoInfo */

$this->title = 'Update Video Info: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Video Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="video-info-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
