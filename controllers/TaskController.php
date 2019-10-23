<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use app\models\Task;
use app\models\TaskMessage;
use app\models\User;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
 
/**
 * TaskController implements the CRUD actions for Task model.
 */
class TaskController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['task'],
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
     * Lists all Task models.
     * @return mixed
     */
    public function actionIndex()
    {
        $tasks = Task::findAll(['parent' => 0]);
        return $this->render('index', [
            'tasks' => $tasks,
        ]);
    }
    
    public function actionAll() {
        $tasks = Task::findAll(['parent' => 0]);
        return $this->render('all', [
            'tasks' => $tasks,
        ]);
    }
    
    public function actionUser($id)
    {
        $tasks = Task::find()->where(['performer' => $id])->orderBy('date_out')->All();
        return $this->render('index', [
            'tasks' => $tasks,
        ]);
    }
    
    public function actionNoPerformer()
    {
        $tasks = Task::findAll(['performer' => '']);
        return $this->render('index', [
            'tasks' => $tasks,
        ]);
    }
    
    public function actionNoDate()
    {
        $tasks = Task::findAll(['date_out' => NULL]);
        return $this->render('index', [
            'tasks' => $tasks,
        ]);
    }
    
    public function actionXuaction()
    {
        $tasks = Task::findAll(['status' => 6]);
        return $this->render('index', [
            'tasks' => $tasks,
        ]);
    }

    /**
     * Displays a single Task model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $msg = new TaskMessage();
        $model = $this->findModel($id);
        if ($msg->load(Yii::$app->request->post())) {
            $msg->task_id = $id;
            $msg->user_id = Yii::$app->user->id;
            if ($msg->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $messages = TaskMessage::findAll(['task_id' => $model->id]);
            return $this->render('view', [
                'model' => $model,
                'msg' => $msg,
                'messages' => $messages,
            ]);
        }
    }

    /**
     * Creates a new Task model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id = NULL)
    {
        $model = new Task();
        $model->parent = $id;
        $users = User::find()->All();
        
        if ($model->load(Yii::$app->request->post())) {
            $model->creator = Yii::$app->user->id;
            $model->date_in = date("Y-m-d"); 
            If ($model->performer) $model->status = 2;
            else $model->status = 1;
            
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
                'tasks' => Task::find()->All(),
                'users' => $users,
                'parent_id' => $id,
            ]);
        }
    }

    /**
     * Updates an existing Task model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        $users = User::find()->All();

        if ($model->load(Yii::$app->request->post())) {
            If ($model->status == 1) $model->performer = 0;
            If ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
                'tasks' => Task::find()->All(),
                'users' => $users,
            ]);
        }
    }

    /**
     * Deletes an existing Task model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        /*$this->findModel($id)->delete();

        return $this->redirect(['index']);*/
        return $this->redirect(['view', 'id' => $id]);
        
    }
    
    public function showTasks($id) {
        $model = $this->findModel($id);
        return $this->renderPartial('shotView',['model' => $model]);
    }
    
    public function fullLink($id)
    {
        return $this->renderPartial('fullLink',
            [
                'model' => $this->findModel($id),
                'user_id' => Yii::$app->user->identity->profile_id,
            ]);
    }

    /**
     * Finds the Task model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Task the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Task::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
