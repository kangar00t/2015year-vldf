<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use app\models\Team;
use app\models\Teams;
use app\models\User;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

class TeamController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['update', 'delete', 'create'],
                    'rules' => [
                        [
                            'actions' => ['update', 'delete'],
                            'allow' => true,
                            'roles' => ['admin'],
                        ],
                        [
                            'actions' => ['create'],
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                        
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'find' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    
    public function actionView2($id)
    {
        return $this->render('view2', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {

            $model = new Team();
    
            if ($model->load(Yii::$app->request->post())) {
                $model->status = 1;

                $model->creator = Yii::$app->user->identity->profile_id;
                
                If ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        
    }

    public function actionUpdate($id)
    {
        $dir = Yii::getAlias('@app/img/emblems/');
        $model = $this->findModel($id);
            
        if ($model->load(Yii::$app->request->post())) {
            
            If ($file = UploadedFile::getInstances($model, 'logo3')) {
                $model->logo3 = $file[0];
                $format = pathinfo($model->logo3, PATHINFO_EXTENSION); 
            } else 
                $model->logo3 = NULL;
            
                                    
            If ($model->validate()) {
                If ($model->logo3)
                    $model->logo = 'logo_team_'.$model->id.'.'.$format;  
                If ($model->save()) {
                    If ($model->logo3)
                        $update = $model->logo3->saveAs($dir.$model->logo);
                    
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
            else {
                return $this->render('update', [
                    'model' => $model,
                    'users' => User::find()->orderBy('username')->All(),
                ]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
                'users' => User::find()->orderBy('username')->All(),
            ]);
        }
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    
    public function actionFind()
    {

        if (isset($_POST['name'])) {

            $name = $_POST['name'];
            $teams = Team::find()->where(['like', 'name', $name])->All();
                
            echo $this->renderPartial('find', [
                'teams' => $teams,
            ]);
        }
    }

    protected function findModel($id)
    {
        if (($model = Team::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
