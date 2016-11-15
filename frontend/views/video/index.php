<?php
/**
 * User: keven
 * Date: 2016/11/15
 * Time: 15:16
 */
use \backend\models\VideoUpload;
$flag = false;
?>

<?php foreach ($models as $key=>$model):?>
    <?php if($key%4 ==0):?>
        <?php $flag = true;?>
<div class="row">
<?php endif;?>
    <div class="col-md-3">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title" style="overflow:hidden;text-overflow:ellipsis;">
                    <nobr><?= $model->name; ?></nobr>
                </h3>
            </div>
            <div class="panel-body">
                <img src="<?=Yii::$app->params['imgServer'].VideoUpload::COVER_IMG_PATH.$model->cover_img;?>" class="img-responsive" style="height:150px;" alt="">
            </div>
            <div class="panel-footer"><div><a href="###">播放</a> | <a href="<?= \yii\helpers\Url::to(['detail','id'=>$model->id])?>">详情</a></div></div>
        </div>
    </div>
    <?php if(($key+1)%4 ==0):?>
</div>
<?php endif;?>
<?php endforeach;?>



<?php
echo \yii\widgets\LinkPager::widget([
    'pagination' => $pages,
])
?>

