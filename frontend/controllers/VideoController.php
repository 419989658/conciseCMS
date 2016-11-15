<?php
/**
 * User: keven
 * Date: 2016/11/11
 * Time: 16:51
 */

namespace frontend\controllers;


use common\models\model\Tag;
use common\models\model\VideoInfo;
use yii\data\Pagination;
use yii\helpers\VarDumper;
use yii\web\Controller;

class VideoController extends Controller
{
    public function actionIndex()
    {
        $query = VideoInfo::find()->where(['status'=>1])->orderBy(['id'=>SORT_DESC]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount'=>$countQuery->count()]);
        $models = $query->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('index',[
            'models'=>$models,
            'pages'=>$pages,
        ]);
    }
    public function actionDetail($id){
        $model = VideoInfo::find()->where(['id'=>$id])->one();
        $videoModel = new \common\component\VideoComponent();
        $tags = $videoModel->getTagByVideoId($model->id);
        return $this->render('detail',['model'=>$model,'tags'=>$tags]);

    }

    public function actionFindVideoByTag($tagId)
    {
        $videoModel = new \common\component\VideoComponent();
        $filterData = $videoModel->getVideoByTagId($tagId);
        $tag = Tag::findOne(['id'=>$tagId]);
        return $this->render('find-video-by-tag',['filterData'=>$filterData,'tag'=>$tag]);
    }
}