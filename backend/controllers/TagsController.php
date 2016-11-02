<?php
/**
 * User: sometimes
 * Date: 2016/10/31
 * Time: 19:54
 */

namespace backend\controllers;


use backend\models\TagForm;
use yii\web\Controller;
class TagsController extends Controller
{
    public function actionIndex()
    {
        $model = TagForm::className();
        return $this->render('index');
    }
}