<?php
/**
 * User: keven
 * Date: 2016/9/23
 * Time: 14:07
 */

namespace frontend\controllers;


use Faker\Factory;
use yii\web\Controller;

class CustomerController extends Controller
{
    public function actionSender()
    {
        $factoru = Factory::create('zh_CN');
        for ($i=0;$i<20;$i++){
            
        }
    }
}