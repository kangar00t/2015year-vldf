<?php

namespace app\models;

use Yii;
use app\models\Profile;
use app\models\TurnirTeam;
use app\models\TurnirEtap;
use app\models\TurnirStage;
use app\models\Team;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

use app\components\widgets\PageTitle;

/**
 * This is the model class for table "{{%turnir}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $shotname
 * @property string $started_at
 * @property string $ended_at
 * @property integer $stages
 * @property integer $group
 * @property integer $playoff
 * @property integer $status
 * @property integer $creator
 */
class Turnir extends \yii\db\ActiveRecord
{
    const STATUS_NEW = 0;
    const STATUS_SET = 1;
    const STATUS_START = 2;
    const STATUS_END = 3;
    const STATUS_DELETE = 9;
    
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%turnir}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'shotname', 'stage', 'status', 'creator'], 'required'],
            [['started_at', 'ended_at'], 'safe'],
            [['stage', 'group', 'playoff', 'status', 'creator'], 'integer'],
            [['name', 'shotname'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'shotname' => 'Сокращение',
            'started_at' => 'Начало',
            'ended_at' => 'Окончание',
            'stage' => 'Стадий',
            'group' => 'Группы',
            'playoff' => 'Этапы плэй-офф',
            'status' => 'Статус',
            'creator' => 'Организатор',
        ];
    }
    public function getStatusName()
    {
        switch ($this->status)  {

            case $this::STATUS_NEW :
                return 'Новый';
                break;
            case $this::STATUS_SET :
                return 'Набор команд';
                break;
            case $this::STATUS_START :
                return 'Идет';
                break;
            case $this::STATUS_END :
                return 'Окончен';
                break;
            case $this::STATUS_DELETE :
                return 'Удален';
                break;
        }
    }
    
    public function getTurnirTeams()
    {
        return $this->hasMany(TurnirTeam::className(), ['turnir_id' => 'id'])->orderBy('position');
    }
    
    public function getTurnirTeamsOne()
    {
        return $this->hasMany(TurnirTeam::className(), ['turnir_id' => 'id'])->where(['stage_id' => null])->joinWith('team')
            ->orderBy(Team::tableName().'.name');
    }
    
    public function getTeams()
    {
        return $this->hasMany(Team::className(),['id' => 'team_id'])
                ->via('turnirTeams')->orderBy('name');
    }
    
    public function getStagesArray()
    {
        for ($i=1;$i<=$this->stage;$i++) {
            $stages[$i] = $i;
        }
        return $stages;
    }
    
    public function getStages()
    {
        return $this->hasMany(TurnirStage::className(), ['turnir_id' => 'id'])->orderBy('sort');
    }
    
    public function getTurs()
    {
        return Game::find()->select('tur')->where([
            'turnir_id' => $this->id,
        ])->orderBy('tur')->distinct()->asArray()->All();
    }
    
    public function getEtaps()
    {
        return $this->hasMany(TurnirEtap::className(), ['stage_id' => 'id'])
        ->via('stages')->orderBy('sort');
    }
    
    public function getLink()
    {
        return Html::a($this->name, ['/turnir/'.$this->id], ['class' => '']);
    }
    
    public function getTeamsForUser() {
        
        $teams = Team::find()->where(['creator' => Yii::$app->user->identity->profile->id])->orderBy('name')->All();
        return $teams;
    }
    
    public function getGames()
    {
        return $this->hasMany(Game::className(), ['turnir_id' => 'id'])->orderBy('date, time');
    }
    public function getStatistics()
    {
        return $this->hasMany(Statistic::className(), ['game_id' => 'id'])->via('games');
    }

    public function getBestStat()
    {
        return $this->hasMany(Statistic::className(), ['game_id' => 'id'])->via('games')->where(['is_best' => 1]);
    }

    public function getGamesTehn()
    {
        return $this->hasMany(Game::className(), ['turnir_id' => 'id'])->where(['>','tehn1', 0])->orWhere(['>','tehn2', 0]);
    }

    public function getBest()
    {
        $ar = [];
        foreach ($this->bestStat as $best) {
            $ar[$best->profile_id]['count']++;
            $ar[$best->profile_id]['model'] = Profile::findOne($best->profile_id);
        }
        ArrayHelper::multisort($ar, 'count', 'SORT_DESC');
        return $ar;
    }

    public function getDate_out()
    {
        $date_s = explode('-',$this->ended_at);
        return date("Y-m-d", mktime( 0, 0, 0, $date_s[1], $date_s[2]+1, $date_s[0]));
    }

    public function getDate_in()
    {
        $date_s = explode('-',$this->started_at);
        return date("Y-m-d", mktime( 0, 0, 0, $date_s[1], $date_s[2]-1, $date_s[0]));
    }
    
    public function goalsArray() {
        $stat = Yii::$app->db->createCommand("
            SELECT 
                vldf_statistic.profile_id as pl,
                vldf_statistic.team_id as tm,
                SUM(vldf_statistic.goals) as ss 
            FROM vldf_statistic 
            INNER JOIN vldf_game
             WHERE 
                vldf_statistic.game_id=vldf_game.id AND 
                vldf_game.turnir_id=$this->id AND 
                vldf_statistic.goals>0 
              GROUP BY pl
            ORDER BY ss DESC
         ")->queryAll();
         return $stat;
    }
    
    public function cardsArray() {
        
        $stat = Yii::$app->db->createCommand("
            SELECT 
                vldf_statistic.profile_id as pl, 
                vldf_statistic.team_id as tm,
                SUM(vldf_statistic.cards) as ss 
            FROM vldf_statistic 
            INNER JOIN vldf_game
             WHERE 
                vldf_statistic.game_id=vldf_game.id AND 
                vldf_game.turnir_id=$this->id AND 
                vldf_statistic.cards>0 
              GROUP BY pl
            ORDER BY ss DESC
         ")->queryAll();
         return $stat;
    }
    
    public function showTitle() {
        
        If (Yii::$app->user->can('admin'))
            return  PageTitle::widget([
                'options' => [
                    'name' => $this->name,
                    'links' => [
                        [
                            'name' => 'Таблица',
                            'href' => '/turnir/'.$this->id,
                        ],
                        [
                            'name' => 'Календарь',
                            'href' => '/turnir/calendar/'.$this->id,
                        ],
                        [
                            'name' => 'Статистика',
                            'href' => '/turnir/statistics/'.$this->id,
                        ],
                        [
                            'name' => 'Лучшие',
                            'href' => '/turnir/best/'.$this->id,
                        ],
                        [
                            'name' => 'Технички',
                            'href' => '/turnir/tehn/'.$this->id,
                        ],
                        [
                            'name' => 'Дисквалификации',
                            'href' => '/turnir/disqualification/'.$this->id,
                        ],
                        [
                            'name' => 'Команды',
                            'href' => '/turnir-team/turnir/'.$this->id,
                        ],
                        [
                            'name' => 'Этапы',
                            'href' => '/turnir-etap/'.$this->id,
                        ],
                        [
                            'name' => 'Редактировать',
                            'href' => '/turnir/update/'.$this->id,
                        ],
                    ],
                ],
            ]);
        else
            return  PageTitle::widget([
                'options' => [
                    'name' => $this->name,
                    'links' => [
                        [
                            'name' => 'Таблица',
                            'href' => '/turnir/'.$this->id,
                        ],
                        [
                            'name' => 'Календарь',
                            'href' => '/turnir/calendar/'.$this->id,
                        ],
                        [
                            'name' => 'Статистика',
                            'href' => '/turnir/statistics/'.$this->id,
                        ],
                    ],
                ],
            ]);
    }
}