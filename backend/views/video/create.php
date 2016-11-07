<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\model\VideoInfo */

$this->title = 'Create Video Info';
$this->params['breadcrumbs'][] = ['label' => 'Video Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="video-info-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'uploadModel'=>$uploadModel,
        'tagsData'=>$tagsData,
    ]) ?>

</div>
