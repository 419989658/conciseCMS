<?php
/**
 * User: keven
 * Date: 2016/10/24
 * Time: 16:45
 */
use \yii\widgets\DetailView;
$this->title='查看用户详细信息';
$this->params['breadcrumbs'][] = ['label'=>'用户管理','url'=>['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= DetailView::widget([
        'model'=>$model,
        'attributes'=>[
            'username',
            'email',
        ],
    ]);
?>