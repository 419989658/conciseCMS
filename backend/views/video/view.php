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
    <!-- 生成标签展示的样式-->
    <?php
    $labelStr='';
        foreach($tags as $tag){
            $labelStr.='<label class="btn btn-success" style="margin:5px;">
            <a href="'.\yii\helpers\Url::to(['video/search','tagId'=>$tag['id']]).'" style="color:#fff;">
            '.$tag['name'] .'
            </a></label>';
        }
    ?>
    <?= DetailView::widget([
        'model' => $model,
        'options'=>[
            'class'=>'box box-success table detail-view table-hover'
        ],
        'attributes' => [
            'id',
            'name',
            'issue_date:datetime',
            'play_time',
            [
                'label'=>'视频标签',
                'format'=>'raw',
                'value'=>$labelStr,
            ],
            [
                'label'=>'封面图片',
                'value'=> Yii::$app->params['imgServer'].VideoUpload::COVER_IMG_PATH.$model->cover_img,
                //'format' => ['image',['width'=>'40','height'=>'30',]],
                'format' => ['image'],
            ],
            [
                'label'=>'缩略图',
                'value'=> Yii::$app->params['imgServer'].VideoUpload::THUMB_IMG_PATH.$model->thumb_img,
                //'format' => ['image',['width'=>'40','height'=>'30',]],
                'format' => ['image'],
            ],
            [
                'label'=>'视频原始播放地址',
                'value'=>Yii::$app->params['videoServer'].$model->origin_url,
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
