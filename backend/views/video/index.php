<?php

use yii\helpers\Html;
use yii\grid\GridView;
use \backend\models\VideoUpload;

/* @var $this yii\web\View */
/* @var $searchModel common\models\query\VideoInfoQuery */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '视频中心';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="video-info-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加视频文件', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


<!--// \hyii2\avatar\AvatarWidget::widget(['imageUrl'=>'']);-->

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options'=>[
            'class'=>'box box-success table grid-view'
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label'=>'电影名称',
                'attribute'=>'name',
                'format' => 'raw',
                'value'=>function($model){
                    return Html::img(Yii::$app->params['imgServer'].VideoUpload::COVER_IMG_PATH.$model['cover_img'], ['height' => '32', 'width' => '32',])
                    .'&nbsp;&nbsp;'. Html::a ( $model ['name'], ['video/view',
                        'id' => $model['id'],], ['data-pjax' => 0, 'target' => '_blank']);
                }
            ],
            [
                'label'=>'视频标签',
                'format'=>'raw',
                'value'=>function($model){
                    $videoModel = new \common\component\VideoComponent();
                    $tags = $videoModel->getTagByVideoId($model->id);
                    $labelStr='';
                    foreach($tags as $tag){
                        $labelStr.='<label class="btn btn-sm btn-success" style="margin:5px;">
                        <a href="'.\yii\helpers\Url::to(['video/search','tagId'=>$tag['id']]).'" style="color:#fff;">
                        '.$tag['name'] .'
                        </a></label>';
                    }
                    return $labelStr;
                },
            ],
            // 'issue_date',
            // 'play_time:datetime',
            // 'cover_img',
            // 'thumb_img',
            // 'play_url:url',
            // 'status',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>


































