<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\query\VideoInfoQuery */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Video Infos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="video-info-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Video Info', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'actor_id',
            'tag_id',
            'album_id',
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
