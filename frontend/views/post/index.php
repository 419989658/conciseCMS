<?php
    $this->title='文章列表';
$this->params['breadcrumbs'][]=$this->title;
?>
<div class="panel panel-primary">
    <div class="panel-heading">
        文章
    </div>
    <div class="panel-body">
        <?php foreach($models as $model): ?>
            <div class="media">
                <a href="###" class="media-left">
                    <img src="http://www.runoob.com/wp-content/uploads/2014/06/64.jpg" alt="" class="media-object">
                </a>
                <div class="media-body">
                    <h4 class="media-heading"><a href="<?=\yii\helpers\Url::toRoute(['post/item','id'=>$model->id])?>"><?= $model->title ?></a> &nbsp;&nbsp;&nbsp;<small><?=$model->author; ?></small></h4>
                    <p><?= substr($model->content,0,255)?>...</p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <p><?php echo \yii\widgets\LinkPager::widget(['pagination'=>$pagination]) ?></p>
</div>