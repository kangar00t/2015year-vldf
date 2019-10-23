<?php

namespace app\controllers;

use Yii;
use app\models\Doc;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\filters\AccessControl;

/**
 * DocController implements the CRUD actions for Doc model.
 */
class DocController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['delete', 'create', 'update'],
                    'rules' => [
                        [
                            'actions' => ['delete', 'create', 'update'],
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
     * Lists all Doc models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index', [
            'docs' => Doc::find()->all(),
            'dir' => '/web/docs/',
        ]);
    }

    /**
     * Displays a single Doc model.
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
     * Creates a new Doc model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $dir = Yii::getAlias('@app/web/docs/');
        $model = new Doc();
        $model->status = 1;
        $model->type = 1;
        $model->name = 'default';

        if ($model->load(Yii::$app->request->post()) ) {

            If ($file = UploadedFile::getInstances($model, 'doc')) {
                $model->doc = $file[0];
                $format = pathinfo($model->doc, PATHINFO_EXTENSION);
            } else 
                $model->doc = NULL;

            If ($model->validate() && $model->save()) {
                If ($model->doc) {
                    $model->name = 'doc_'.$model->id.'.'.$format;
                    $model->save();
                    $f_upload = $model->doc->saveAs($dir.$model->name);
                }
                
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Doc model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $dir = Yii::getAlias('@app/web/docs/');
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) ) {

            If ($file = UploadedFile::getInstances($model, 'doc')) {
                $model->doc = $file[0];
                $format = pathinfo($model->doc, PATHINFO_EXTENSION);
            } else 
                $model->doc = NULL;

            If ($model->validate() && $model->save()) {
                If ($model->doc) {
                    $model->name = 'doc_'.$model->id.'.'.$format;
                    $model->save();
                    $f_upload = $model->doc->saveAs($dir.$model->name);
                }
                
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                echo '<hr>';
                print_r($model->errors);
                echo '<hr>';
                die('Обнаружены ошибки при загрузке. Сохраните строку выше и отправьте администратору сайта.');
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Doc model.
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
     * Finds the Doc model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Doc the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Doc::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
