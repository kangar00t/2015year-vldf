<?php

namespace app\controllers;

use Yii;
use app\models\News;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * NewsController implements the CRUD actions for News model.
 */
class NewsController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                    'class' => AccessControl::className(),
                'only' => ['update', 'delete', 'create'],
                    'rules' => [
                    
                        [ 
                            'actions' => ['create', 'update', 'delete'],
                            'allow' => true,
                            'roles' => ['admin'],
                        ],
                        
                    ],
                ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all News models.
     * @return mixed
     */
    public function actionIndex()
    {

        return $this->render('index', [
            'news_all' => News::find()->orderBy('status DESC, created_at DESC')->where('status > 0')->All(),
        ]);
    }

    /**
     * Displays a single News model.
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
     * Creates a new News model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new News();
        $dir = Yii::getAlias('@app/img/news/');
        
        if ($model->load(Yii::$app->request->post())) {
            
            $model->created_at = date("Y-m-d H:i:s");
            $model->creator_id = Yii::$app->user->id;
            $model->status = 1;
            
            
            If ($file = UploadedFile::getInstances($model, 'logo3')) {
                $model->logo3 = $file[0];
                $format = pathinfo($model->logo3, PATHINFO_EXTENSION); 
            } else 
                $model->logo3 = NULL;
                
 
            If ($model->validate()) {
               
                If ($model->logo3)
                    
                    
                If ($model->save()) {
                    If ($model->logo3) {
                        $model->image = 'news_image_'.$model->id.'.'.$format;
                        $model->save();
                        $update = $model->logo3->saveAs($dir.$model->image);
                    }
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } else 
                return $this->render('create', [
                'model' => $model,
            ]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing News model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $dir = Yii::getAlias('@app/img/news/');
        
        if ($model->load(Yii::$app->request->post())) {
            
            
            If ($file = UploadedFile::getInstances($model, 'logo3')) {
                $model->logo3 = $file[0];
                $format = pathinfo($model->logo3, PATHINFO_EXTENSION); 
            } else 
                $model->logo3 = NULL;
                
 
            If ($model->validate()) {
               
                //If ($model->logo3)
                    
                    
                If ($model->save()) {
                    If ($model->logo3) {
                        $model->image = 'news_image_'.$model->id.'.'.$format;
                        $model->save();
                        $update = $model->logo3->saveAs($dir.$model->image);
                    }
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } else 
                return $this->render('update', [
                'model' => $model,
            ]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing News model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        
        $model = $this->findModel($id);
        $dir = Yii::getAlias('@app/img/news/');
        
        if(file_exists($dir.$model->image)) unlink($dir.$model->image);
        
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the News model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return News the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = News::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
