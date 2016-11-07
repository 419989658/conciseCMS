<?php
/**
 * User: keven
 * Date: 2016/11/7
 * Time: 11:00
 */

namespace frontend\controllers;


use app\models\Test;
use Faker\Factory;
use yii\helpers\VarDumper;
use yii\web\Controller;

class TestController extends Controller
{
    public function actionIndex()
    {
        $model = new Test();
        $data = $model::findAll([
            'id'=>[1,2,3,4,5,55],
        ]);
        VarDumper::dump($data,10,1);
    }
    public function actionGener()
    {
        $faker = Factory::create('zh_CN');
        $record = 0;
        for ($i = 0;$i<200000;$i++){
            $posts = new Test();
            $posts->name = $faker->name;
            $posts->introduce = $faker->text($maxNbCharts = 1000);
            if($posts->insert()){
                $record++;
            }
        }
        echo '一共添加了'.$record.'条数据';
    }
}