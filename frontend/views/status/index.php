<?php
/**
 * User: sometimes
 * Date: 2016/10/22
 * Time: 10:14
 */

/* @var $model frontend\models\StatusForm*/
echo \yii\widgets\DetailView::widget([
    'model'=>$model,
    'attribute'=>[
        'text',
        [
            'label'=>'权限',
            'value'=>$model->
        ]
    ],
]);