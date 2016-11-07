<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use \backend\models\UploadConfig;
use \backend\models\VideoUpload;
use \common\models\model\VideoInfo;
/* @var $this yii\web\View */
/* @var $model common\models\model\VideoInfo */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '视频信息', 'url' => ['index']];
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
            'issue_date:datetime',
            'play_time',
            [
                'label'=>'封面图片',
                'value'=> VideoUpload::COVER_IMG_PATH.$model->cover_img,
                //'format' => ['image',['width'=>'40','height'=>'30',]],
                'format' => ['image'],
            ],
            [
                'label'=>'缩略图',
                'value'=> VideoUpload::THUMB_IMG_PATH.$model->thumb_img,
                //'format' => ['image',['width'=>'40','height'=>'30',]],
                'format' => ['image'],
            ],
            [
                'label'=>'视频原始播放地址',
                'value'=>Yii::$app->params['videoService'].$model->origin_url,
                'format'=>'url',
            ],
            'play_url:url',
            [
                'label'=>'状态',
                'value'=>VideoInfo::getStatus($model->status),
            ],
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
