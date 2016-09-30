<?php

use yii\helpers\Html;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel common\models\TagsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$ajax_url = \yii\helpers\Url::to(['ajax-view']);
$csrf_param = Yii::$app->request->csrfParam;
$csrf_token = Yii::$app->request->csrfToken;

$this->registerJs("
    $('div.tags-index').on('click','tr',function(){
        var id = $(this).data('key');
        $.ajax({
            'type' : 'GET',
            'url'  : '$ajax_url',
            'dataType' : 'html',
            'data':{
                '$csrf_param' : '$csrf_token',
                'id' : id
            },
            'success' : function(data){
            $('#tags-detail').html(data);
            }
        });
    })

");


$this->title = 'Tags';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tags-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Tags', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php \yii\widgets\Pjax::begin();?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'tag',
        //    'meta_description',
        //    'tag_img',
        //    'created_at',
          //   'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php \yii\widgets\Pjax::end();?>
</div>

<div id="tags-detail">
    <?php echo $this->render('_view',['model'=>$tags]) ?>
</div>