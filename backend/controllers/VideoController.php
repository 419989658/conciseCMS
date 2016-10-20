<?php

namespace backend\controllers;

use common\component\VideoComponent;
use common\component\WebUploadProcess;
use Yii;
use common\models\model\VideoInfo;
use common\models\query\VideoInfoQuery;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * VideoController implements the CRUD actions for VideoInfo model.
 */
class VideoController extends Controller
{
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
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new VideoInfo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $videoCpt =  new VideoComponent();
        $videoModel = $videoCpt->getVideoModel();
        $uploadModel = $videoCpt->getVideoUpload();
        if(Yii::$app->request->isPost){
            $upload = new WebUploadProcess();
            $upload->init();
            $videoModel = $videoCpt->upload($videoModel,$uploadModel);
            if($videoModel->load(Yii::$app->request->post()) && $videoModel->save()){
              //  echo $videoModel->id;die;
                return $this->redirect(['view','id'=>$videoModel->id]);
            }else{
                //TODO 保存数据库失败的处理
            }
        }
            return $this->render('create', [
                'model' => $videoModel,
                'uploadModel'=>$uploadModel,
            ]);
    }


    /**
     * Updates an existing VideoInfo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
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
