<?php
/**
 * User: keven
 * Date: 2016/11/15
 * Time: 15:16
 */
use \backend\models\VideoUpload;
\frontend\assets\CkPlayerAsset::register($this);
$flag = false;
$this->title='标签查询----_-----|  '.$tag->name;
$this->params['breadcrumbs'][] = ['label'=>'视频主页','url'=>['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1>查询标签: <span class="btn btn-primary"><?=$tag->name;?></span></h1>
<p>

</p>
<?php foreach ($filterData as $key=>$data):?>
    <?php if($key%4 ==0):?>
        <?php $flag = true;?>
        <div class="row">
    <?php endif;?>
    <div class="col-md-3">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title" style="overflow:hidden;text-overflow:ellipsis;">
                    <nobr><?= $data['name']; ?></nobr>
                </h3>
            </div>
            <div class="panel-body">
                <img src="<?=Yii::$app->params['imgServer'].VideoUpload::COVER_IMG_PATH.$data['cover_img'];?>" class="img-responsive" style="height:150px;" alt="">
            </div>
            <div class="panel-footer"><div><a href="<?=Yii::$app->params['videoServer'].$data['origin_url'];?>" class="playVideo">播放</a> | <a href="<?= \yii\helpers\Url::to(['view','id'=>$data['id']])?>">详情</a></div></div>
        </div>
    </div>
    <?php if(($key+1)%4 ==0):?>
        </div>
    <?php endif;?>
<?php endforeach;?>
<div id="a1"></div>


