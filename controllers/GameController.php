<?php

namespace app\controllers;

use Yii;
use app\models\Game;
use app\models\Team;
use app\models\TurDate;
use app\models\TurTime;
use app\models\Turnir;
use app\models\TurnirTeam;
use app\models\Choose;
use app\models\Field;
use app\models\Referee;
use app\models\Profile;
use app\models\Statistic;
use app\models\Option;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * GameController implements the CRUD actions for Game model.
 */
class GameController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['update', 'delete', 'create', 'time', 'time-choose', 'time-admin', 'mass-update'],
                    'rules' => [
                        [
                            'actions' => ['delete', 'create', 'mass-update'],
                            'allow' => true,
                            'roles' => ['admin'],
                        ],
                        [
                            'actions' => ['time-admin'],
                            'allow' => true,
                            'roles' => ['timeManager'],
                        ],
                        [
                            'actions' => ['time', 'update', 'time-choose'],
                            'allow' => true,
                            'roles' => ['@'],
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
     * Lists all Game models.
     * @return mixed
     */
    public function actionIndex()
    {
        $games = Game::find()->where('TO_DAYS(NOW()) - TO_DAYS(date) <= 7')->orderBy('date DESC, field_id, time')->All();
        
        /*foreach (Game::find()->where([
            'turnir_id' => 827,
            'tur' => 4,
        ])->all() as $game) {
            $game->resetDate();
        }*/
        
        return $this->render('index', [
            'games' => $games,
        ]);
    }
    
    public function actionPerenos()
    {

        $games = Yii::$app->db->createCommand('SELECT * FROM games')->queryAll();
        foreach ($games as $game) {
            echo '<div>';
                $team1 = Yii::$app->db->createCommand('SELECT * FROM composition WHERE id='.$game['red_id'])
                ->queryOne();
                $team2 = Yii::$app->db->createCommand('SELECT * FROM composition WHERE id='.$game['blue_id'])
                ->queryOne();
                $t = Yii::$app->db->createCommand('SELECT * FROM tour WHERE id='.$game['tour_id'])
                ->queryOne();


                if ($t["tourney_id"] == 864) {
                    $t1_id = Yii::$app->db->createCommand('SELECT t.id FROM vldf_team as t INNER JOIN vldf_turnir_team as tt WHERE t.id = tt.team_id AND tt.turnir_id = '.$t["tourney_id"].' AND t.name = "'.$team1['name'].'"')
                    ->queryOne();

                    $t2_id = Yii::$app->db->createCommand('SELECT t.id FROM vldf_team as t INNER JOIN vldf_turnir_team as tt WHERE t.id = tt.team_id AND tt.turnir_id = '.$t["tourney_id"].' AND t.name = "'.$team2['name'].'"')
                    ->queryOne();



                    $t1 = ($t1_id['id']) ? Team::findOne($t1_id['id'])->link : $team1['name'];
                    $t2 = ($t2_id['id']) ? Team::findOne($t2_id['id'])->link : $team2['name'];

                    if ($t1_id['id'] && $t2_id['id'])
                        $g = Game::find()->where('((team1_id = '.$t1_id['id'].' AND team2_id = '.$t2_id['id'].') OR (team1_id = '.$t2_id['id'].' AND team2_id = '.$t1_id['id'].')) AND turnir_id = '.$t["tourney_id"])->one();

                    if ($g->tur && ($g->tur != $t['num'])) {
                        $g->tur = $t['num'];
                        $g->save();
                    }

                    $g = $g ? $g->tur : '?';

                    echo $t['num'].' : '.Turnir::findOne($t['tourney_id'])->name.' ('.$t["tourney_id"].') ___ '.$t1.' - '.$t2.' ( '.$g.' )';
                }

                $g = $to1 = $to2 = $ok1 = $ok2 = null;

            echo '</div>';
        }
    }
        

    /**
     * Displays a single Game model.
     * @param integer $id
     * @return mixed
     */
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
    
    /**
     * Creates a new Game model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Game();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Game model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        If (Yii::$app->user->id AND (Yii::$app->user->can('gameManager') OR (Yii::$app->user->identity->profileModel->isRefGame($id)))) {
            $model = $this->findModel($id);
            $stats = [];
            /*var_dump($model->team1List);
            echo $model->turDate->date;
            die();*/
            foreach ($model->team1List as $t1list) {
                $stat1 = $t1list->StatForUpdate($id);
                $stats[] = $stat1;
            }
            foreach ($model->team2List as $t2list) {
                $stat1 = $t2list->StatForUpdate($id);
                $stats[] = $stat1;
            }
    
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                
                if(isset($_POST['Statistic'])) {
                                                    
                    if (Statistic::loadMultiple($stats, Yii::$app->request->post()) &&
                        Statistic::validateMultiple($stats)) {
                        $count = 0;
                        foreach ($stats as $stat) {
                           // populate and save records for each model
                            If ($stat->isLoad) {
                                if ($stat->save()) {
                                    $count++;
                                }
                            } else {
                                $stat->delete();
                            }
    
                            /*var_dump($stat);
                            echo '<hr/>';*/
                            
                        }
                        //die();
                        Yii::$app->session->setFlash('success', "Игра успешно обновлена. $count записей статистики матча записаны.");
                    }    
                    /*foreach ($post as $i=>$lstat) {
    
                        If (!$lstat['isLoad']) {
                            $nstat = new Statistic();
                            $nstat->load($lstat);
                            var_dump($nstat);
                            die();
                        }
                    }*/
                    //die();
                }
                If ($model->etap->type == 1) {
                    $model->turnirTeam1->turnirTable->updateStat();
                    $model->turnirTeam2->turnirTable->updateStat();
                    $model->etap->updateLvOch();
                }
                
                return $this->redirect(['view', 'id' => $model->id]);
                
            } else {
                return $this->render('update', [
                    'model' => $model,
                    'fields' => Field::find()->All(),
                    'referees' => Referee::find()
                        ->joinWith('profile')
                        ->where([Referee::tableName().'.status' => 1])
                        ->orderBy(Profile::tableName().'.lname')
                        ->All(),
                    'stat' => $stats,
                ]);
            }
        } else {
            throw new \yii\web\HttpException(403, 'Редактирование чужого профиля запрещено.');
        }
    }

    public function actionMassUpdate() {
        $games = Game::find()->where([
            'turnir_id' => [807,808,809,810],
            'tur' => 2,
        ])->All();
        return $this->render('massupdate', [
            'games' => $games,
            'fields' => Field::find()->All(),
        ]);
    }
    /**
     * Deletes an existing Game model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        //$this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    
    public function actionFind()
    {
        
        $m = [1, 1.3, 3, 3.5, 5, 5.7, 7, 7.9, 9, 9.11, 11, 11.13, 13, 13.15, 15];
        $m2 = $m;
        $m3 = $m;
        
        Foreach ($m as $c1) {
            Foreach ($m2 as $c2) {
                Foreach ($m3 as $c3) {
                    If ($c1+$c2+$c3 == 30) die("1");
                    else echo $c1+$c2+$c3.'<br>';
                }
            }
        }
        
    }
    
    public function actionProtocol($id)
    {
        
        /*$games = Game::find()->where(['turnir_id' => $id, 'tur' => 1])->All();
        return $this->renderPartial('protocol', [
            'games' => $games,
        ]);*/
        If ($id == 813) $games = Game::find()->where(['turnir_id' => $id, 'tur' => 3])->All();
        elseif ($id == 814) $games = Game::find()->where(['turnir_id' => $id])->All();
        else $games = Game::find()->where(['turnir_id' => $id, 'tur' => 13])->All();
        return $this->renderPartial('protocol', [
            'games' => $games,
        ]);
    }
    
    public function actionProtocolGame($id)
    {
        return $this->renderPartial('protocol', [
            'games' => Game::find()->where(['id' => $id])->All(),
        ]);
    }
    
    public function actionProtocolField($id, $date)
    {
        return $this->renderPartial('protocol', [
            'games' => Game::find()->where(['field_id' => $id, 'date' => $date])->All(),
        ]);
    }
    
    public function actionProtocolEmpty()
    {
        return $this->renderPartial('protocol-empty');
    }
    
    public function actionProtocolDate($date)
    {
        return $this->renderPartial('protocol', [
            'games' => Game::find()->where(['date' => $date])->orderBy('field_id, time')->All(),
        ]);
    }
    
    public function actionTime() {
        
        $turdates = TurDate::find()->where('status = 1 AND date >= now()')->All();
        
        return $this->render('time', [
            'turdates' => $turdates,
            'choosetime' => Option::find()->where(['name' => 'choosetime'])->all()[0],
        ]);
    }
    
    public function actionTimeChoose($id) {

        if (Option::find()->where(['name' => 'choosetime'])->all()[0]->value) {
        
            $game = Game::findOne($id);
            $chooses = $game->ChooseForUpdate();
            $rchooses = [];
            
            If ($game->rivalTeam->id) {
                Foreach ($chooses as $ch) {
                    $rch = Choose::find()->where([
                        'team_id' => $game->rivalTeam->id,
                        'tur_time_id' => $ch->tur_time_id,
                    ])->one();
                    $rchooses[] = $rch;
                }
            }
            
            if (isset($_POST['Choose'])) {
                                                    
                if (Choose::loadMultiple($chooses, Yii::$app->request->post()) &&
                    Choose::validateMultiple($chooses)) {
                    $count = 0;
                    /*var_dump($chooses);
                    die();*/
                    foreach ($chooses as $choose) {
                        if ($choose->choose) {
                            $countok++;
                        }
                    }

                    If ((isset($_POST['perenos']) AND false) OR (($countok > 6) AND ($game->turnir_id == 851)) OR (($countok > 8) AND ($game->turnir_id > 851))) {

                    //If ($countok > 5) {
                        foreach ($chooses as $choose) {
                            if ($choose->save()) {
                                $count++;
                            }
                        }
                        Yii::$app->session->setFlash('success', "Выбор обновлен ($count вариантов).");
                    } else {
                        If($game->turnir_id > 851)
                            Yii::$app->session->setFlash('error', "Вы не можете выбрать более 4 варианта НЕ МОЖЕМ (не более 3 для НУ).");
                       elseif($game->turnir_id == 822)
                                Yii::$app->session->setFlash('error', "Вы не можете выбрать более 1 варианта НЕ МОЖЕМ. Если Вас не устраивает такой вариант или вы хотите перенести игру, поставьте галочку \"Перенос игры ( или отмена тура ) при не совпадении.\"");
                    }
                }
            }
                
            return $this->render('time-choose', [
                'game' => $game,
                'chooses' => $chooses,
                'rchooses' => $rchooses,
            ]);
        } else echo 'Выбор времени не доступен';
    }
    
    public function actionTimeAdmin() {
        $turdates = TurDate::find()->where('status = 1 AND date > NOW()')->All();

        $games = [];
        $i = 0;
        Foreach ($turdates as $turdate)
            Foreach ($turdate->games as $game) {

                $games[] = $game;
            }

        if(isset($_POST['Game'])) {
            if (Game::loadMultiple($games, Yii::$app->request->post()) &&
                Choose::validateMultiple($games)) {
                Foreach ($games as $game) {
                    If ($game->tur_time_id) {
                        $tur_time = TurTime::findOne($game->tur_time_id);
                        $game->time = $tur_time->time;
                        $game->date = $tur_time->turDate->date;
                        $game->field_id = $tur_time->turDate->field_id;
                        $game->save();
                    }
                } 
            }
        }
        return $this->render('time-admin', [
            'games' => $games,
        ]);
    }
    
        
    public function actionProtocolSet($id) {
        if (\Yii::$app->request->isAjax) {
            $model = Game::findOne($id);
            If ($model->protocol) $model->protocol = 0;
            else $model->protocol = 1;
            If ($model->save())
                echo 'ok!';
        }
    }
    
    public function actionDateGames() {
        if (\Yii::$app->request->isAjax) {
            $date = $_POST['date'];
            If ($date) {
                $games = Game::find()->where(['date' => $date])->orderBy('field_id, time')->All();
            
                return $this->renderPartial('_date-games', [
                    'games' => $games,
                ]);   
            } else
                return "Нет игр для отображения. У нас межсезонье, 'либо летописец опять потерял свои свитки (c)'.";
        }         
    }

    /**
     * Finds the Game model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Game the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Game::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
