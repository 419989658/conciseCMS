<?php

namespace frontend\controllers;

use common\models\model\Tag;

class TagsController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $tags = Tag::find()->all();
        return $this->render('index',['tags'=>$tags]);
    }

}
