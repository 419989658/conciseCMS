<?php
/**
 * User: sometimes
 * Date: 2016/10/31
 * Time: 19:54
 */

namespace backend\controllers;


use backend\models\TagForm;
use common\component\VideoComponent;
use common\models\model\Tag;
use yii\helpers\VarDumper;
use yii\web\Controller;
use Faker\Factory;
class TagController extends Controller
{
    public function actionIndex()
    {
        $videoCpt = new VideoComponent();
        $a = $videoCpt->getTagsByVideoId(1);

        VarDumper::dump($a,10,1);
    }
    public function actionGener()
    {
        $faker = Factory::create('zh_CN');
        $record=0;
        for($i=0;$i<200;$i++){
            $posts = new Tag();
            $posts->name = $faker->name;
            if($posts->insert()){
                $record++;
            }
        }
        echo '一共添加了'.$record.'条数据';
    }

    public function actionGenerVideoTag()
    {

    }
}