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
                <a href="#">
                    <img class="media-object" width="54px" height="54px" src="<?php echo "$tag->tag_img"; ?>" alt="<?php echo "$tag->tag"; ?>">
                </a>
            </div>
            <div class="media-body">
                <h4 class="media-heading">
                    <a href="<?php echo \yii\helpers\Url::toRoute(['post/index','id'=>$tag->id]); ?>"><?php echo "$tag->tag"; ?></a>
                </h4>
            </div>
        </div>
    </div>
    <?php endforeach;?>
</div>
