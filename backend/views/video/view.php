<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use \backend\models\UploadConfig;
/* @var $this yii\web\View */
/* @var $model common\models\model\VideoInfo */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Video Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="video-info-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'actor_id',
            'tag_id',
            'album_id',
            'issue_date',
            'play_time:datetime',
            [
                'label'=>'封面图片',
                'value'=> UploadConfig::COVER_IMG_PATH.$model->cover_img,
                //'format' => ['image',['width'=>'40','height'=>'30',]],
                'format' => ['image'],
            ],
            [
                'label'=>'缩略图',
                'value'=> UploadConfig::COVER_IMG_PATH.$model->thumb_img,
                //'format' => ['image',['width'=>'40','height'=>'30',]],
                'format' => ['image'],
            ],
            'origin_url:url',
            'play_url:url',
            'status',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
