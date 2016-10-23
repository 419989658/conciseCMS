<?php
/**
 * User: sometimes
 * Date: 2016/10/22
 * Time: 10:13
 */

namespace frontend\controllers;


use frontend\models\StatusForm;
use yii\web\Controller;

class StatusController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCreate()
    {
        $modelForm = new StatusForm();
        if($modelForm->load(\Yii::$app->request->post()) && $modelForm->validate())
        {
            return $this->render('index',['model'=>$modelForm]);
        }
        return $this->render('create',['model'=>$modelForm]);
    }
}