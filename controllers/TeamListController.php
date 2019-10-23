<?php

namespace app\controllers;

use Yii;
use app\models\Profile;
use app\models\TeamList;
use app\models\TurnirTeam;
use app\models\Turnir;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * TeamListController implements the CRUD actions for TeamList model.
 */
class TeamListController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'actions' => ['turnir-update', 'delete'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['tteam-list'],
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
     * Lists all TeamList models.
     * @return mixed
     */
    public function actionIndex()
    {
        
        /*foreach (TeamList::find()->where(['profile_id' => 0])->All() as $tlist) {
            $tlist->profile_id = $tlist->id;
            If ($tlist->save()) echo '.';
        }
        die('ok!');*/
        $dataProvider = new ActiveDataProvider([
            'query' => TeamList::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TeamList model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    
    public function actionTurnir($tteam_id) 
    {
        $tteam = TurnirTeam::findOne($tteam_id);
        $model = new TeamList();
        $model->turnir_id = $tteam->turnir_id;
        $model->tteam_id = $tteam->id;
        $model->team_id = $tteam->team_id;
        $model->type = 11;
        return $this->render('turnir', [
            'model' => $model,
            'tteam' => $tteam,
            'team' => $tteam->team,
            'turnir' => $tteam->turnir,
        ]);
    }
    
    public function actionAdmin($tteam_id) 
    {
        $tteam = TurnirTeam::findOne($tteam_id);
        if(isset($_POST['TeamList'])) {
            $tteam->load(Yii::$app->request->post());
            $tteam->save();
            $tlists = Yii::$app->request->post('TeamList');     
            foreach ($tlists as $i=>$tlist) {
                if(!empty($tlist['id'])) {
                    $model = TeamList::findOne(['id' => $tlist['id']]);
                    $model->added = $tlist['added'];
                    $model->save();
                }
            }
            
            $profiles = Yii::$app->request->post('Profile');
            foreach ($profiles as $i=>$profile) {
                if(!empty($profile['id'])) {
                    $model = Profile::findOne(['id' => $profile['id']]);
                    $model->status = $profile['status'];
                    $model->save();
                }
            }
            return $this->redirect(['admin-info']);  
        }
        return $this->render('admin', [
            'model' => $model,
            'tteam' => $tteam,
        ]);
    }
    
    public function actionAdminInfo() 
    {
        $turnirs = Turnir::find()->where(['status' => 2])->All();
        return $this->render('admin-info', [
            'turnirs' => $turnirs,
        ]);
    }
    
    public function actionAdminInfo2() 
    {
        $tlists = TeamList::find()->where(['>', 'date_in', '2015-07-26'])->All();
        return $this->render('admin-info2', [
            'tlists' => $tlists,
        ]);
    }

    public function actionTurnirUpdate($tteam_id)
    {

        /*if (!Yii::$app->user->can('admin'))
            return $this->render('_closed');*/

        if ((Yii::$app->user->id != 17) AND (Yii::$app->user->id != 24) AND (Yii::$app->user->id != 361))
            return $this->render('_closed');
        
        $tteam = TurnirTeam::findOne($tteam_id);
        
        $profile = new Profile(['scenario' => 'player']);
        $model = new TeamList();
        $model->turnir_id = $tteam->turnir_id;
        $model->tteam_id = $tteam->id;
        $model->team_id = $tteam->team_id;

        $time = new \DateTime('now', new \DateTimeZone('UTC'));
        $model->date_in = $time->format('Y-m-d');
        
        $model->date_out = $tteam->turnir->date_out;
            
        //поправить для трансферного окна
        $model->added = 1;
        
        $model->type = 11;
        
        //ТУТ ДЕЛАЕМ ПОПРАВКУ ДЛЯ ТУРНИРОВ ПРОШЕДШИХ
        // нужно поменять дату входа и выхода
        // у нас при добавлении будет добавлять игрок на весь период
       /* If ($model->date_in > $tteam->turnir->ended_at) {
            $model->added = 0;
            $date_start = explode('-',$tteam->turnir->started_at);
            $model->date_in = date("Y-m-d", mktime( 0, 0, 0, $date_start[1], $date_start[2]-1, $date_start[0]));
            $model->type = 13;
        }*/
            
        
        if ($model->load(Yii::$app->request->post())) {
            
            If ((count($tteam->teamListNow)>17) AND (Yii::$app->user->id != 24)) die('Лимит игроков (18) достигнут');
            //If (($tteam->teamListAddedCount>2) AND (Yii::$app->user->id != 24)) die('Лимит дозаявок исчерпан');
            If ($model->date_in < $model->turnir->date_in) $model->date_in = $model->turnir->date_in;
            
            if ($model->new && $profile->load(Yii::$app->request->post()) && $profile->save()) {
                $model->profile_id = $profile->id;
            }
            if ($model->save()) {
                return $this->redirect(['turnir-update', 'tteam_id' => $tteam_id]);    
            }
        } else return $this->render('turnir-update', [
            'model' => $model,
            'profile' =>$profile,
            'tteam' => $tteam,
            'team' => $tteam->team,
            'turnir' => $tteam->turnir,
        ]); 
        
    }
    
    public function actionTteamList() {
        
        $tteam_id = $_POST["tteam_id"];
        $tteam = TurnirTeam::findOne($tteam_id);
        
        echo $this->renderPartial('_tteam', [
            'tteam' => $tteam,
        ]);
    }
    
    public function actionCreate()
    {
        $model = new TeamList();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

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

    public function actionDelete()
    {
        if (isset($_POST['tl_id'])) {
            $tlist = $this->findModel($_POST['tl_id']);
            $time = new \DateTime('now', new \DateTimeZone('UTC'));
            $tlist->date_out = $time->format('Y-m-d');

			if ((Yii::$app->user->id != 17) AND (Yii::$app->user->id != 24))
            	echo "Удаление временно запрещено!";
            else {
            	$tlist->save();
            	echo "Игрок удален из заявки!";	
            }
        }
    }

    public function actionDateinUpdate()
    {
        if (isset($_POST['tl_id'])) {
            $tlist = $this->findModel($_POST['tl_id']);
            $tlist->date_in = $_POST['date_in'];
            If ($tlist->date_in < $tlist->turnir->date_in) $tlist->date_in = $tlist->turnir->date_in; 

            if ((Yii::$app->user->id != 17) AND (Yii::$app->user->id != 24))
                echo "Нет прав";
            else {
                if ($tlist->save())
                    echo "Успешно"; 
                else echo "Ошибка";
            }
        }
    }

    protected function findModel($id)
    {
        if (($model = TeamList::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
