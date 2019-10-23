<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use app\models\TurnirTeam;
use app\models\Turnir;
use app\models\Team;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TurnirTeamController implements the CRUD actions for TurnirTeam model.
 */
class TurnirTeamController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                    'rules' => [
                        [
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
     * Lists all TurnirTeam models.
     * @return mixed
     */
    public function actionIndex()
    {
        foreach (TurnirTeam::find()->where(['turnir_id' => 817])->All() as $tteam) {
            //If ($tteam->stage_id) {
                if (!count(TurnirTeam::find()->where([
                    'stage_id' => null,
                    'team_id' => $tteam->team_id,
                    'turnir_id' => $tteam->turnir_id,
                ])->All())) {
                    echo $tteam->turnir_id.'-';
                    $tteamNew = new TurnirTeam();
                    $tteamNew->team_id = $tteam->team_id;
                    $tteamNew->turnir_id = $tteam->turnir_id;
                    $tteamNew->status = 777;
                   // if ($tteamNew->save()) echo 'ok';
                }
           // }
        }
        echo '---'.$k;
        die($k);
        $dataProvider = new ActiveDataProvider([
            'query' => TurnirTeam::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TurnirTeam model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
            //'teams' => $this->teams,
        ]);
    }

    /**
     * Creates a new TurnirTeam model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TurnirTeam();
        if ($model->load(Yii::$app->request->post())) {
            
            foreach ($model->turnir->stages as $stage) {
                
                $model->status = TurnirTeam::STATUS_ACTIVE;
                $model->stage_id = $stage->id;
                
                if ($model->save()) {
                    $model = new TurnirTeam();
                    $model->load(Yii::$app->request->post());
                }
            }
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'turnirs'  => Turnir::find()->orderBy('started_at DESC')->All(),
                'teams'  => Team::find()->orderBy('name')->All(),
            ]);
        }
    }
    
    public function actionCreateTurnir($id)
    {
        $model = new TurnirTeam();
        $model->turnir_id = $id;
        
        if ($model->load(Yii::$app->request->post())) {
            
            foreach ($model->turnir->stages as $stage) {
                
                $model->status = TurnirTeam::STATUS_ACTIVE;
                $model->stage_id = $stage->id;
                
                if ($model->save()) {
                    $model = new TurnirTeam();
                    $model->turnir_id = $id;
                    $model->load(Yii::$app->request->post());
                }
            }
            $model->status = TurnirTeam::STATUS_ACTIVE;
            $model->save();
            
            return $this->redirect(['turnir-team/create-turnir/'.$id]);
        } else {
            return $this->render('create-turnir', [
                'model' => $model,
                'turnir'  => Turnir::findOne($id),
                'teams'  => Team::find()->orderBy('name')->All(),
            ]);
        }
    }

    /**
     * Updates an existing TurnirTeam model.
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
                'turnirs'  => Turnir::find()->All(),
                'teams'  => Team::find()->All(),
            ]);
        }
    }

    /**
     * Deletes an existing TurnirTeam model.
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
     * Finds the TurnirTeam model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TurnirTeam the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
     
    public function actionTurnir($id)
    {
        $turnir = Turnir::findOne($id);
         
        if(isset($_POST['TurnirTeam'])) {
            $post = Yii::$app->request->post('TurnirTeam');
            
            foreach ($post as $i=>$tteam) {
                if(!empty($tteam['id'])) {
                    $model = TurnirTeam::findOne(['id' => $tteam['id']]);
                    $model->attributes = $tteam;
                    $model->save();
                }
            }
        }
        
        return $this->render('turnir',[
            'turnir' => $turnir,
        ]);
    }
    
    protected function findModel($id)
    {
        if (($model = TurnirTeam::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
