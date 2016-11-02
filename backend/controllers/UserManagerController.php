<?php
/**
 * User: keven
 * Date: 2016/10/24
 * Time: 9:33
 */

namespace backend\controllers;


use backend\models\AddUserForm;
use common\models\User;
use common\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class UserManagerController extends Controller
{
    public function actionIndex()
    {
        $userSearch = new UserSearch();
        $dataProvider = $userSearch->search(\Yii::$app->request->queryParams);
        return $this->render('index',['dataProvider'=>$dataProvider,'searchModel'=>$userSearch]);
    }

    public function actionCreate()
    {
        $model = new AddUserForm();
        if($model->load(\Yii::$app->request->post())&&$model->validate()){
            $model->save();
            return $this->redirect(['index']);
        }
        return $this->render('create',['model'=>$model]);
    }

    public function actionView($id)
    {
        return $this->render('view',[
            'model'=>$this->findModel($id),
        ]);
    }

    public function actionUpdate($id)
    {
        $user = $this->findModel($id);
        if(\Yii::$app->request->isPost){
            if($user->updateData(\Yii::$app->request->post())){
                $user->save();
                return $this->redirect(['view','id'=>$user->id]);
            }
        }
        return $this->render('update',['model'=>$user]);
    }
    public function findModel($id)
    {
        $model = User::findOne($id);
        if($model !== null){
            return $model;
        }else{
            throw new NotFoundHttpException('没有找到该页面');
        }
    }
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();
        return $this->redirect(['index']);
    }
    public function actionBatchDelUser($ids)
    {
        if(!empty($ids)){
            $delIds = explode(',',$ids);
            foreach ($delIds as $id){
                $this->actionDelete($id);
            }
            \Yii::$app->session->setFlash('success','批量删除内容成功');
        }
        return $this->redirect(\Yii::$app->getRequest()->getReferrer());
    }
}