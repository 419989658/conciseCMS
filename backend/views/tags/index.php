<?php
/**
 * User: sometimes
 * Date: 2016/10/31
 * Time: 19:55
 */
$this->title='标签管理';
$this->params['breadcrumbs'][] = $this->title;
use \backend\assets\TagsAsset;
use \yii\bootstrap\Html;

TagsAsset::register($this);
?>

<div class="tags-control">
    <?=  Html::a('提交修改的标签',\yii\helpers\Url::toRoute(['tags/create']),['class'=>'btn btn-primary','id'=>'submitKeys']) ?>
        <div class="row">
            <h1>已有标签 <small class="text-danger">点击提交按钮才会保存</small></h1>
            <input id="tagKeys" type="text" class="tags" value="foo,bar,baz,roffle" />
        </div>
</div>
