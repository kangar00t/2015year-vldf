<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use app\models\TurnirEtap;
use app\models\Turnir;
use app\models\TurnirEtapType;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/**
 * TurnirEtapController implements the CRUD actions for TurnirEtap model.
 */
class TurnirEtapController extends Controller
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
     * Lists all TurnirEtap models.
     * @return mixed
     */
     
    public function actionAll()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => TurnirEtap::find(),
        ]);

        return $this->render('all', [
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionIndex($id)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => TurnirEtap::find()->where(['turnir_id' => $id])->orderBy('stage_id'),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'turnir' => Turnir::findOne($id),
        ]);
    }

    /**
     * Displays a single TurnirEtap model.
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
     * Creates a new TurnirEtap model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = new TurnirEtap();
        $model->game3 = 0;
        $turnir = Turnir::findOne($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['turnir/'.$turnir->id]);
        } else {
            if (\Yii::$app->request->isAjax){
                echo $this->renderPartial('create', [
                    'model' => $model,
                    'turnir' => $turnir,
                    'types' => TurnirEtapType::find()->All(),
                ]);
            } else
            return $this->render('create', [
                'model' => $model,
                'turnir' => $turnir,
                'types' => TurnirEtapType::find()->All(),
            ]);
        }

    }
    

    /**
     * Updates an existing TurnirEtap model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $turnir = Turnir::findOne($model->turnir_id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $turnir->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'turnir' => $turnir,
                'types' => TurnirEtapType::find()->All(),
            ]);
        }
    }

    /**
     * Deletes an existing TurnirEtap model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $turnir = Turnir::findOne($this->findModel($id)->turnir_id);
        $this->findModel($id)->delete();
        return $this->redirect(['index', 'id' => $turnir->id]);
    }
    
        
    public function actionPositionArray() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if (($parents != null)) {
                $etap_id = $parents[0];
                If ($etap = TurnirEtap::findOne($etap_id)) {
                    $out = $etap->positionArray(); 
                    echo Json::encode(['output'=>$out, 'selected'=>'']);
                    return;
                }
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }

    /**
     * Finds the TurnirEtap model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TurnirEtap the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TurnirEtap::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
