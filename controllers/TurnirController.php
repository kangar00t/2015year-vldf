<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use app\models\Turnir;
use app\models\Assn;
use app\models\Team;
use app\models\TurnirStage;
use app\models\TurnirTable;
use app\models\TurnirTeam;
use app\models\TurnirEtapType;
use app\models\TurnirEtap;
use app\models\Game;
use app\models\Games;
use app\models\TeamList;
use app\models\Profile;
use app\models\Statistic;
use app\models\Referee;
use app\models\User;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\base\Model;
use yii\web\Response;
use yii\widgets\ActiveForm;

class TurnirController extends Controller
{
    
    private $_model;
    
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['update', 'delete', 'create', 'perenos', 'generatestage', 'Generategames', 'add-team', 'best', 'tehn'],
                    'rules' => [
                        [
                            'actions' => ['update', 'delete', 'create', 'perenos', 'generatestage', 'Generategames', 'add-team', 'best', 'tehn'],
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

    public function actionPerenos() 
    {
        foreach (TeamList::find()->where(['>', 'turnir_id', 844])->All() as $tl) {
            if (count($t = TeamList::find()->where(['profile_id' => $tl->profile_id, 'tteam_id' => $tl->tteam_id])->andWhere(['>', 'id', $tl->id])->All()) > 0) {
                echo $tl->profile_id.'-';
            }
        }
        
        
    }

    public function actionIndex()
    {
        return $this->render('index', [
            'turnirs' => Turnir::find()->where('status != 9')->orderBy('started_at DESC')->All(),
        ]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);
        //var_dump($model->turnirTeams);
        foreach ($model->turnirTeams as $tteam) {
            
            If (count($tteam->turnirTable)) {
                $tteam->turnirTable->updateStat();
            }
        }

        foreach ($model->etaps as $etap) {
            $etap->updateLvOch();
        }
        return $this->render('view', [
            'model' => $model,
            'types' => TurnirEtapType::find()->All(),
        ]);
    }

    public function actionCreate()
    {
        $model = new Turnir();
        $model->status = Turnir::STATUS_NEW;
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            If ($model->stage) {
                For ($i=1; $i<=$model->stage; $i++) {
                    $stages = new TurnirStage();
                    $stages->turnir_id = $model->id;
                    $stages->sort = $i;
                    $stages->save();
                }
            }
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'creators' => Assn::find()->All(),
            ]);
        }
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $stages_old = $model->stage;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $stages = $model->stage;
            If ($stages_old != $stages) {
                $model->stage = $stages_old;
                $model->save();
            }
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'creators' => Assn::find()->All(),
            ]);
        }
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = Turnir::STATUS_DELETE;
        $model->save();
        return $this->redirect(['index']);
    }
    
    public function actionCalendar($id) 
    {
        $model = $this->findModel($id);
        $game = new Game();

        /**
         * Случайная перетусовка тура
         */

        /*If (Yii::$app->user->can('admin') AND ($model->id == 828)) {

                foreach (Game::find()->where(['turnir_id' => $model->id])->andWhere(['<', 'tur', 20])->all() as $game) {
                    $game->tur = $game->tur+20;
                    $game->save();
                }

        }

        $mas[21]=1;
        $mas[22]=4;
        $mas[23]=6;
        $mas[24]=15;
        $mas[25]=13;
        $mas[26]=19;
        $mas[27]=18;
        $mas[28]=2;
        $mas[29]=9;
        $mas[30]=3;
        $mas[31]=7;
        $mas[32]=12;
        $mas[33]=17;
        $mas[34]=5;
        $mas[35]=10;
        $mas[36]=14;
        $mas[37]=8;
        $mas[38]=16;
        $mas[39]=11;

        For ($i=21;$i<40;$i++) {
            foreach (Game::find()->where(['turnir_id' => $model->id, 'tur' => $i])->all() as $game) {
                $game->tur = $mas[$i];
                $game->save();
            }
        }*/
        //If (Yii::$app->user->can('admin') OR ((!$model->id == 836) AND (!$model->id == 837)))
        return $this->render('calendar', [
                'model' => $model,
                'game' => $game,
            ]);
    }
    
    public function actionStatistics($id) {
        $model = $this->findModel($id);
        
        return $this->render('statistics', [
            'model' => $model,
        ]);
    }

    public function actionBest($id) {
        $model = $this->findModel($id);
        
        return $this->render('best', [
            'model' => $model,
        ]);
    }
    public function actionTehn($id) {
        $model = $this->findModel($id);
        
        return $this->render('tehn', [
            'model' => $model,
        ]);
    }

    public function actionDisqualification($id) {
        $model = $this->findModel($id);
        
        $echo = '';
        
        foreach ($model->stages as $stage) {
            foreach ($stage->etaps as $etap) {
                //var_dump($etap->gamesOfDate);
                Foreach ($etap->gamesOfDate as $game) {
                    
                    If ($game->date) {
                        $echo .= '<div class="row g-infi">';
                        $echo .= '<div class="col-xs-4 col-sm-4 col-md-4">';
                        $echo .= '<p>'.$game->team1->link.'-'.$game->team2->link.'</p>';
                        
                        $echo .= '</div>';
                        $echo .= '<div class="col-xs-8 col-sm-8 col-md-8">';
                        foreach ($game->team1list as $tlist) {
                            $stat = $tlist->statGame($game->id);
                            If ($cards[$tlist->profile_id] > 0) 
                                '<p>'.$tlist->profile->link.' - '.$cards[$tlist->profile_id].' очков дисквалификации до игры</p>';
                            If ($cards[$tlist->profile_id] > 2) 
                                $echo .= '<p>'.$tlist->profile->link.' - дисквалификация</p>';
                            If (!$stat AND ($cards[$tlist->profile_id] > 2) AND ($game->haveGols())) {
                                $cards[$tlist->profile_id] = $cards[$tlist->profile_id]-3;
                                $echo .= '<p>'.$tlist->profile->link.' - отбыл дисквалификацию</p>';
                            }
                            If ($stat->cards) {
                                $cards[$tlist->profile_id]++;
                                If ($stat->cards > 1) $cards[$tlist->profile_id] = $cards[$tlist->profile_id]+2;
                                $echo .= '<p>'.$tlist->profile->link.' - '.$cards[$tlist->profile_id].' очков дисквалификации всего</p>';
                            }
                        }
                        $echo .= '</div></div>';
                    }
                    
                } 
            }
        }
        return $this->render('disqualification', [
                'echo' => $echo,
                'model' => $model,
            ]);
    }
    
    public function actionGeneratestage($id) 
    {
        $stage = TurnirStage::findOne($id);

        //echo ($stage->isStaffed());die();
        If ($stage->isStaffed()) {
            foreach ($stage->etaps as $etap) {
                
                If ($etap->type == 1) {
                    foreach ($etap->turnirTeams as $tteam) {
                        $ttable = new TurnirTable();
                        $ttable->tteam_id = $tteam->id;
                        $ttable->turnir_id = $tteam->turnir_id;
                        $ttable->team_id = $tteam->team_id;
                        $ttable->poz = $etap->id;
                        $ttable->save();
                    }
                }
                elseIf ($etap->type == 2) {
                    die('No play-off generate');
                }
                
            }
        }
        return $this->redirect(['turnir/'.$stage->turnir_id]);
    }
    
    public function actionGenerategames($id)
    {
        $stage = TurnirStage::findOne($id);
        
        If ($stage->isTable()) {
            foreach ($stage->etaps as $etap) {
                
                If ($etap->type == 1) {
                    
                    If (count($etap->games)) {
                        die('В этом этапе уже созданы игры!');
                    }
                    
                    $k = 0;  //** Количество команд **//
                    foreach ($etap->turnirTeams as $tteam) {
                        $k++;
                        $teams[$k] = $tteam->team;
                    }
                    
                    If ($k != count($etap->turnirTable)) die('Не верное количество команд!');
                                    
                    If ($k%2) {
                        $k++;
                        $teams[$k] = NULL;
                    }
                    
                    for ($i=1; $i<$k; $i++) {
                        
                        for ($j=1; $j<=$k/2; $j++) {
                            $m7=$j+$k/2;
                            echo '<p>'.$teams[$j]->id.'-'.$teams[$m7]->id.'</p>('.$j.'-'.$m7.')';
                            
                            If ($teams[$j] AND $teams[$m7]) {
                                $game = new Game();
                                $game->team1_id = $teams[$j]->id;
                                $game->team2_id = $teams[$m7]->id;
                                $game->turnir_id = $stage->turnir_id;
                                $game->etap_id = $etap->id;
                                $game->tur = $i;
                                $game->save();
                            }
                        }
                    
                    
                        For ($i1=$k/2; $i1>2; $i1=$i1-1) {
        					$t[1]=$teams[$i1-1];
        					$teams[$i1-1]=$teams[$i1];
        					$teams[$i1]=$t[1];
        				}
                        
        				$m7=$k/2+1;
                        
        				For ($i1=$m7;$i1<$k;$i1++) {
        					$t[1] = $teams[$i1+1];
        					$teams[$i1+1]=$teams[$i1];
        					$teams[$i1]=$t[1];
        				}
                        
        				$t[1]=$teams[2];
        				$teams[2]=$teams[$k];
        				$teams[$k]=$t[1];
                    
                    }
                }
                elseIf ($etap->type == 2) {
                    
                    var_dump($etap->playOffTable());
                    die($etap->playOffTable());
                    
                }
            }
        }
        
        return $this->redirect(['turnir/calendar/'.$stage->turnir_id]);
    }

    public function actionStatusSet($id) {
        if (\Yii::$app->request->isAjax) {
            $model = Turnir::findOne($id);
            $model->status = Turnir::STATUS_SET;
            If ($model->save())
                echo $this->renderPartial('teams', ['model' => $model]);
        }
    }
    
    public function actionAddTeam() {
        if (\Yii::$app->request->isAjax) {
            $post = Yii::$app->request->post();
            $turnir = $post['turnir'];
            $team = $post['team'];
            If (!TurnirTeam::find()->where(['team_id'=>$team, 'turnir_id'=>$turnir])->All()) {
                
                $model = Turnir::findOne($turnir);
                
                $tteam = new TurnirTeam();
                $tteam->team_id = $team;
                $tteam->turnir_id = $turnir;
                $tteam->status = TurnirTeam::STATUS_WAIT;
                If ($tteam->save())
                    echo $this->renderPartial('teams', ['model' => $model]);                
            }

        }
    }
    
    public function actionValidateEtap() {
        $newEtap = new TurnirEtap();
        if (\Yii::$app->request->isAjax && $newEtap->load(\Yii::$app->request->post())) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            echo json_encode(ActiveForm::validate($newEtap));
            \Yii::$app->end();
        }
    }
    
    public function actionTableGames() {
        if (\Yii::$app->request->isAjax) {
            $post = Yii::$app->request->post();
            $team_id = $post['team'];
            $etap_id = $post['etap'];
            $etap = TurnirEtap::findOne($etap_id);
            $team = Team::findOne($team_id);
            $games = [];
            if (count($etap->turnirTable))
	            foreach ($etap->turnirTable as $ttable) {
	                $game = Game::find()->where([
	                    'etap_id' => $etap_id,
	                    'team1_id' => $team_id,
	                    'team2_id' => $ttable->team_id
	                ])->orWhere([
	                    'etap_id' => $etap_id,
	                    'team2_id' => $team_id,
	                    'team1_id' => $ttable->team_id
	                ])->One();
	                $games[] = $game;
	            }
            echo $this->renderPartial('table_games', [
                'games' => $games,
                'team_id' => $team_id,
                'etap' => $etap,
                'team' => $team,
            ]);  
        }
    }
    
    public function actionFind($id)
    {

        if (isset($_POST['tur'])) {
            
            $tur = $_POST['tur'];
            $team = $_POST['team'];
            
            If ($team) {
                If ($tur)
                    $games = Game::find()->where([
                        'turnir_id' => $id,
                        'team1_id' => $team,
                        'tur' => $tur,
                    ])->orWhere([
                        'turnir_id' => $id,
                        'team2_id' => $team,
                        'tur' => $tur,
                    ])->all();
                else
                    $games = Game::find()->where([
                        'turnir_id' => $id,
                        'team1_id' => $team,
                    ])->orWhere([
                        'turnir_id' => $id,
                        'team2_id' => $team,
                    ])->orderBy('tur')->all();
            } elseif ($tur) 
                $games = Game::find()->where([
                        'turnir_id' => $id,
                        'tur' => $tur,
                    ])->all();
            else $games = Game::find()->where([
                        'turnir_id' => $id,
                    ])->all();
                
            echo $this->renderPartial('calendar_find', [
                'games' => $games,
            ]);
        }
    }
    
    protected function findModel($id)
    {
        if($this->_model===null)
        {
            if (($this->_model = Turnir::findOne($id)) !== null) {
                return $this->_model;
            } else {
                throw new NotFoundHttpException('The requested page does not exist.');
            }
        }
    }

}
