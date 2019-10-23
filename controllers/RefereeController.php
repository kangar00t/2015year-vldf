<?php

namespace app\controllers;

use Yii;
use app\models\Referee;
use app\models\Profile;
use app\models\User;
use app\models\Game;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * RefereeController implements the CRUD actions for Referee model.
 */
class RefereeController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['update', 'delete', 'create', 'admin'],
                    'rules' => [
                        [
                            'actions' => ['update', 'delete', 'create', 'admin'],
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
     * Lists all Referee models.
     * @return mixed
     */
    public function actionIndex()
    {

        /*var_dump(Referee::findOrderGames());
        die();*/
        $ref = Referee::find()
                ->joinWith('profile')
                ->where([Referee::tableName().'.status' => 1])
                ->orderBy(Profile::tableName().'.lname')
                ->All();

        
        /** УДАЛЕНИЕ ДУБЛЕЙ ЗАПИСЕЙ О СУДЬЯХ
        foreach ($ref as $r) {
            if (count(Referee::find()->where(['profile_id' => $r->profile_id])->all()) > 1) {
                echo $r->profile_id.'<br>';
                $r->delete();
            }
        }*/
        //die();

        return $this->render('index', [
            'referees' => $ref,
        ]);
    }

    /**
     * Displays a single Referee model.
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
     * Creates a new Referee model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Referee();
        $model->status = 1;
        $model->level = 0;

        if ($model->load(Yii::$app->request->post()))
        {
            if (count(Referee::find()->where(['profile_id' => $model->profile_id])->all())) {

                Yii::$app->session->setFlash('error', "Судья уже был добавлен в состав коллегии ранее.");
            }
            elseif ($model->save()) {
                Yii::$app->session->setFlash('success', "Судья был успешно добавлен.");
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } 
        return $this->render('create', [
            'model' => $model,
            'profiles' => Profile::find()->All(),
            'users' => User::find()->orderBy('username')->All(),
        ]);
        
    }

    /**
     * Updates an existing Referee model.
     * If update is successful, the browser will be-redirected to the 'view' page.
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
     * Deletes an existing Referee model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    
    public function actionAdmin()
    {
        
        $games = Game::find()->where('TO_DAYS(NOW()) - TO_DAYS(date) <= 7')->orderBy('date DESC, field_id, time')->All();
        
        if(isset($_POST['Game'])) {
                                                    
            if (Game::loadMultiple($games, Yii::$app->request->post()) && Game::validateMultiple($games)) {
                Foreach ($games as $game) {
                    $game->save();
                }
                Yii::$app->session->setFlash('success', "Обновление прошло успешно!");
            }
        }
        return $this->render('admin', [
            'games' => $games,
            'referees' => Referee::find()
                ->joinWith('profile')
                ->where([Referee::tableName().'.status' => 1])
                ->orderBy(Profile::tableName().'.lname')
                ->All(),
        ]);
    }

    /**
     * Finds the Referee model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Referee the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Referee::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
