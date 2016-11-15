<?php
/* @var $this yii\web\View */
$this->title='标签';
$this->params['breadcrumbs'][]=$this->title;
?>

<h1>标签 </h1>

<div class="row">
    <?php foreach($tags as $tag):?>
    <div class="col-md-3">
        <div class="media">
            <div class="media-left">
            </div>
            <div class="media-body">
                <h4 class="media-heading">
                    <a href="<?php echo \yii\helpers\Url::toRoute(['video/find-video-by-tag','tagId'=>$tag->id]); ?>" class="btn btn-primary"><?php echo "$tag->name"; ?></a>
                </h4>
            </div>
        </div>
    </div>
    <?php endforeach;?>
</div>
