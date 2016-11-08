<?php

namespace backend\controllers;

use backend\models\VideoUpload;
use common\component\VideoComponent;
use common\component\WebUploader1;
use common\component\WebUploader_3;
use common\models\model\Tag;
use common\models\model\Tags;
use Yii;
use common\models\model\VideoInfo;
use common\models\query\VideoInfoQuery;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * VideoController implements the CRUD actions for VideoInfo model.
 */
class VideoController extends Controller
{
    public $enableCsrfValidation = false;
    public function actions()
    {
        return [
            'crop'=>[
                'class' => 'hyii2\avatar\CropAction',
                'config'=>[
                    'bigImageWidth' => '200',     //大图默认宽度
                    'bigImageHeight' => '200',    //大图默认高度
                    'middleImageWidth'=> '100',   //中图默认宽度
                    'middleImageHeight'=> '100',  //中图图默认高度
                    'smallImageWidth' => '50',    //小图默认宽度
                    'smallImageHeight' => '50',   //小图默认高度
                    //头像上传目录（注：目录前不能加"/"）
                    'uploadPath' => 'uploads/avatar',
                ]
            ]
        ];
    }
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all VideoInfo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VideoInfoQuery();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single VideoInfo model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $videoModel = new VideoComponent();
        $tags = $videoModel->getTagByVideoId($id);
        return $this->render('view', [
            'model' => $this->findModel($id),
            'tags'=> $tags,
        ]);
    }

    /**
     * Creates a new VideoInfo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $videoModel = new VideoInfo();
        $uploadModel = new VideoUpload();
        $tagsData = new Tag();
        if($videoModel->load(Yii::$app->request->post())){
            $tagIds = Yii::$app->request->post('VideoInfo')['tags'];
            $uploadModel->coverImg = UploadedFile::getInstance($uploadModel,'coverImg');
            $uploadModel->thumbImg = UploadedFile::getInstance($uploadModel,'thumbImg');
            if(!$uploadModel->upload($videoModel)){
                Yii::$app->session->setFlash('danger','上传错误');
            }
            $videoModel->save();
            $videoCpt = new VideoComponent();
            $videoCpt->batchSaveTags($videoModel->id,$tagIds);
            return $this->redirect(['view','id'=>$videoModel->id,]);
        }
            return $this->render('create', [
                'model' => $videoModel,
                'uploadModel'=>$uploadModel,
                'tagsData'=>$tagsData::find()->asArray()->all(),
            ]);
    }

    public function actionUploadVideo()
    {
        if(Yii::$app->request->isPost){
            WebUploader_3::init($_POST,$_FILES)->progress();
        }
    }


    /**
     * Updates an existing VideoInfo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $videoModel = $this->findModel($id);
        $tagsData = new Tag();
        $uploadModel = new VideoUpload();
        $videoCpt = new VideoComponent();
        //获取到旧的标签
        $oldTags = $videoModel->tags = $videoCpt->getTagIdsByVideoId($id);
        $oldTags = is_array($oldTags)?$oldTags:[];
        $videoModel->issue_date = Yii::$app->formatter->AsDatetime($videoModel->issue_date);
        $uploadModel->canEmpty = true;
        if($videoModel->load(Yii::$app->request->post())){
            //获取到新的标签
            $newTags = Yii::$app->request->post('VideoInfo')['tags'];
            $newTags = is_array($newTags)?$newTags:[];
            $uploadModel->coverImg = UploadedFile::getInstance($uploadModel,'coverImg');
            $uploadModel->thumbImg = UploadedFile::getInstance($uploadModel,'thumbImg');

            if(!$uploadModel->upload($videoModel)){
                Yii::$app->session->setFlash('danger','上传错误');
            }
            $videoModel->save();
            //处理标签
            $videoCpt = new VideoComponent();
            $videoCpt->progressTag($videoModel->id,$oldTags,$newTags);
            return $this->redirect(['view','id'=>$videoModel->id,]);
        }
        return $this->render('update', [
            'model' => $videoModel,
            'uploadModel'=>$uploadModel,
            'tagsData'=>$tagsData::find()->asArray()->all(),
        ]);
    }

    /**
     * Deletes an existing VideoInfo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the VideoInfo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return VideoInfo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = VideoInfo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
