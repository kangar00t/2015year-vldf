<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use app\models\Field;
use app\models\Game;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * FieldController implements the CRUD actions for Field model.
 */
class FieldController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['update', 'delete', 'create'],
                    'rules' => [
                        [
                            'actions' => ['update', 'delete', 'create'],
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
     * Lists all Field models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index', [
            'fields' => Field::find()->All(),
        ]);
    }

    /**
     * Displays a single Field model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {


        return $this->render('view', [
            'model' => $this->findModel($id),
            'game' => new Game(),

        ]);
    }

    /**
     * Creates a new Field model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Field();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Field model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $dir = Yii::getAlias('@app/img/fields/');
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            
            If ($file = UploadedFile::getInstances($model, 'img3')) {
                $model->img3 = $file[0];
                $format = pathinfo($model->img3, PATHINFO_EXTENSION); 
            } else 
                $model->img3 = NULL;
            /*var_dump($file);
            die();    */
            If ($model->validate()) {
                If ($model->img3)
                    $model->img = 'img_field_'.$model->id.'.'.$format;  
                If ($model->save()) {
                    If ($model->img3)
                        $update = $model->img3->saveAs($dir.$model->img);
                    
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
            
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Field model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        //$this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Field model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Field the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Field::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
