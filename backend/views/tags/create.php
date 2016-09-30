<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Tags */
use \yii\web\View;

$this->registerCssFile('./css/webuploader.css',[]);
$this->registerJsFile('./js/webuploader.js',['depends' => ['frontend\assets\AppAsset']],View::POS_END);
$this->registerJsFile('./js/myuploader.js',['depends' => ['frontend\assets\AppAsset']],View::POS_END);
$this->title = 'Create Tags';
$this->params['breadcrumbs'][] = ['label' => 'Tags', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tags-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'uploadImg'=>$uploadImg
    ]) ?>

</div>
