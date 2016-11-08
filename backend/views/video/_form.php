<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model common\models\model\VideoInfo */
/* @var $uploadModel backend\models\ImageUpload */
/* @var $form yii\widgets\ActiveForm */
\backend\assets\WebUploaderAsset::register($this);
$tags = array_combine(array_column($tagsData,'id'),array_column($tagsData,'name'));

?>
<div class="video-info-form">
    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data','class'=>'box box-success'],

        //'enableAjaxValidation' => true,
    ]); ?>

    <!-- 修改button.active默认点击样式,此处为标签样式-->
    <?php $this->registerCss('label.btn-primary.active {background-color: #f86090;border-color: #f04d74;}'); ?>
    <!-- 标签选择-->
    <?= $form->field($model,'tags')->checkboxList($tags,[
        'itemOptions'=>[
            'style'=>'display:none',
            'labelOptions'=>[
                'class'=>'btn btn-primary',
                'style'=>'margin:4px 4px 12px 4px;',
                'data-toggle'=>'buttons',
            ],

        ]])->label('视频标签'); ?>

    <!-- 此JS是为了将默认选中的标签反选颜色-->
    <?php $this->registerJs('$(function(){
        $("#videoinfo-tags>label").each(function(){
            if($(this).find("input").attr("checked") == "checked"){
                $(this).addClass("active");
            }
        });
    })') ?>

    <?= $form->field($model, 'issue_date')->widget(DateTimePicker::className(), [
        'options' => ['placeholder' => '','style'=>'max-width:150px'],
        'pluginOptions' => [
            'autoclose' => true,
            'todayHighlight' => true,
        ]
    ]); ?>

    <?= $form->field($model, 'play_time')->textInput(['style'=>'max-width:230px']) ?>

    <?= $form->field($uploadModel, 'coverImg')->fileInput(['multiple' => true, 'accept' => 'image/*'])->label('封面图片') ?>

    <?= $form->field($uploadModel, 'thumbImg')->fileInput(['multiple' => true, 'accept' => 'image/*'])->label('缩略图片') ?>

    <?= $form->field($model,'origin_url')->textInput(['readonly'=>'readonly','style'=>'max-width:500px']) ?>
    <div id="uploader" class="wu-example">
        <!--用来存放文件信息-->
        <div id="thelist" class="uploader-list"></div>
        <div class="btns">
            <a id="picker">选择文件</a>
            <a id="ctlBtn1" class="btn btn-default" style="display: none">开始上传</a>
        </div>
    </div>
    <?php echo $form->field($model, 'name')->textInput(['style'=>'max-width:230px','placeholder'=>'如要保留原文件的名称,可不填']); ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '创建 <span class="glyphicon glyphicon-send"></span> ' : '修改 <span class="glyphicon glyphicon-pencil"></span>', ['id'=>'ctlBtn','class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$this->registerJs("
var 
    BASE_URL='',
    CHECK_CHUNK_SERVICE = UPLOAD_SERVICE = '".\yii\helpers\Url::toRoute(['upload-video'])."';


",\yii\web\View::POS_BEGIN);
?>