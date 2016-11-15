<?php
/**
 * User: keven
 * Date: 2016/11/15
 * Time: 16:14
 */
use \backend\models\VideoUpload;
$this->title=$model->name;
$this->params['breadcrumbs'][] = ['label'=>'视频首页','url'=>['index']];
$this->params['breadcrumbs'][] = $this->title;

\frontend\assets\CkPlayerAsset::register($this);
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <?= $model->name?>
    </div>
    <div class="panel-body">
        封面图:
        <img src="<?=Yii::$app->params['imgServer'].VideoUpload::COVER_IMG_PATH.$model->cover_img;?>" class="img-responsive"  alt="">
        缩略图:
        <img src="<?=Yii::$app->params['imgServer'].VideoUpload::THUMB_IMG_PATH.$model->thumb_img;?>" class="img-responsive"  alt="">
        标签:
        <?php
        $labelStr='';
        foreach($tags as $tag){
            $labelStr.='<label class="btn btn-sm btn-success" style="margin:5px;">
                        <a href="'.\yii\helpers\Url::to(['video/find-video-by-tag','tagId'=>$tag['id']]).'" style="color:#fff;">
                        '.$tag['name'] .'
                        </a></label>';
        }
        echo $labelStr;
        ?>
        <div id="a1"></div>

    </div>
</div>
<div id="a1"></div>

<?php
$this->registerJs("
        var VIDEO_PATH = '".Yii::$app->params['videoServer'].$model->origin_url."';
    ",\yii\web\View::POS_BEGIN);
?>
