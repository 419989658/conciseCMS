<?php
$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label'=>'文章列表','url'=>['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?php echo  $post->title; ?></h1>
<p class="text-muted">作者：<?php echo $post->author; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;标签:<?php foreach ($tags as $tags) {
        echo "<kbd>".$tags['tag']."</kbd>&nbsp;&nbsp;";
    } ?></p>
<p>
    <?php echo yii\helpers\Markdown::process($post->content, 'gfm'); ?>
</p>