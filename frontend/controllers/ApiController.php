<?php
/**
 * User: keven
 * Date: 2016/10/22
 * Time: 14:34
 */

namespace frontend\controllers;


use \yii\web\Response;
use yii\filters\ContentNegotiator;
use yii\web\Controller;

class ApiController extends Controller
{
    public function behaviors()
    {
        return [
            'contentNegotiator' => [
                'class' => ContentNegotiator::className(),
                'formats' => [
                    'application/json' =>Response::FORMAT_JSON,

                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return ['123','456'=>['concise'=>123]];
    }
}