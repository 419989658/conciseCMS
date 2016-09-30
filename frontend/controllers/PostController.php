<?php

namespace frontend\controllers;

use common\models\Posts;
use common\models\Tags;
use Faker\Factory;
use yii\data\Pagination;
use yii\helpers\VarDumper;

class PostController extends \yii\web\Controller
{
    public function actionSender(){
        $faker = Factory::create('zh_CN');
        $record=0;
        for($i=0;$i<20;$i++){
            $posts = new Posts();
            $posts->title = $faker->text($maxNbchars = 20);;
            $posts->author = $faker->name;
            $posts->content = $faker->text($maxNbchars = 3000);
            if($posts->insert()){
                $record++;
            }
        }
        echo '一共添加了'.$record.'条数据';
    }

    public function actionIndex($id='')
    {
        if(!empty($id)){
            $tags = Tags::findOne($id);
            $post = $tags->getPost()->orderBy(['id'=>SORT_DESC]);
        }else{
            $post = Posts::find()->where(['status'=>Posts::STATUS_ACTIVE])->orderBy('id');
        }

        $pages = new Pagination(['totalCount'=>$post->count(),'pageSize'=>8]);
        $models = $post->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('index',[
            'models'=>$models,
            'pagination'=>$pages
        ]);
    }

    public function actionTest(){
        $sql ="select * from t_posts where id=:id";
    $command = \Yii::$app->getDb()->createCommand($sql);
        $post = $command->bindValues([':id'=>2])->queryAll();
        VarDumper::dump($post,10,1);die;
    }



    public function actionItem($id){
        $post = Posts::findOne(['id'=>$id,'status'=>Posts::STATUS_ACTIVE]);
        return $this->render('item',['post'=>$post]);
    }

}

















































































































