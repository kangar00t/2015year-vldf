<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%team_list}}".
 *
 * @property integer $id
 * @property integer $profile_id
 * @property integer $tteam_id
 * @property integer $turnir_id
 * @property integer $team_id
 * @property string $date_in
 * @property string $date_out
 * @property integer $type
 * @property integer $player
 */
class TeamList extends \yii\db\ActiveRecord
{
    public $new;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%team_list}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['profile_id', 'tteam_id', 'turnir_id', 'team_id', 'type'], 'required'],
            [['profile_id', 'tteam_id', 'turnir_id', 'team_id', 'type', 'player', 'added'], 'integer'],
            [['new'], 'boolean'],
            [['date_in', 'date_out'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'profile_id' => 'Profile ID',
            'tteam_id' => 'Tteam ID',
            'turnir_id' => 'Turnir ID',
            'team_id' => 'Team ID',
            'date_in' => 'Date In',
            'date_out' => 'Date Out',
            'type' => 'Type',
            'player' => 'Player',
        ];
    }
    
    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['id' => 'profile_id']);
    }
    
    public function getProfileOld()
    {
        return $this->hasOne(Profile::className(), ['id' => 'profile_id']);
    }

    public function getTeam()
    {
        return $this->hasOne(Team::className(), ['id' => 'team_id']);
    }
    
    public function getTurnir()
    {
        return $this->hasOne(Turnir::className(), ['id' => 'turnir_id']);
    }
    
    public function getGame()
    {
        return $this->hasOne(Game::className(), ['id' => 'game_id']);
    }
    
    public function StatForUpdate($id)
    {
        If (!$stat = Statistic::find()->where([
            'game_id' => $id,
            'team_id' => $this->team_id,
            'profile_id' => $this->profile_id,
        ])->one()) {
            $stat = new Statistic();
            $stat->team_id = $this->team_id;
            $stat->profile_id = $this->profile_id;
            $stat->game_id = $id;
            $stat->isLoad = 0;
        }
        return $stat;
    }
    
    public function StatGame($game) {
        return Statistic::find()->where([
            'game_id' => $game,
            'profile_id' => $this->profile_id,
            'team_id' => $this->team_id,
        ])->one();
        
    }
    
    public function StatGameAll() {
        return Statistic::find()->joinWith('game')->where([
            Statistic::tableName().'.profile_id' => $this->profile_id,
            Statistic::tableName().'.team_id' => $this->team_id,
            Game::tableName().'.turnir_id' => $this->turnir_id,
        ])->all();
    }
    
    public function StatGameTeam() {
        return Statistic::find()->where([
            'profile_id' => $this->profile_id,
            'team_id' => $this->team_id,
        ])->all();
        
    }
    public function StatGameTeamPersent() {
        $gamesProfile = count(Statistic::find()->where([
            'profile_id' => $this->profile_id,
            'team_id' => $this->team_id,
        ])->all());
        
        $gamesTeam = count(Game::find()->where('team1_id = '.$this->team_id.' OR team2_id = '.$this->team_id)->all());
        
        If (!$gamesTeam) return 0;
        return ceil($gamesProfile*100/$gamesTeam);
    }
    
    public function sumGoals() {
        
        $stat = Yii::$app->db->createCommand("
            SELECT 
                SUM(goals) as ss 
            FROM vldf_statistic 
             WHERE 
                goals>0 AND profile_id = ".$this->profile_id." AND team_id = ".$this->team_id."
         ")->queryAll();

         return $stat[0]["ss"];
    }
    
    public function sumGoalsAll() {
        
        $stat = Yii::$app->db->createCommand("
            SELECT 
                SUM(goals) as ss 
            FROM vldf_statistic 
             WHERE 
                goals>0 AND team_id = ".$this->team_id."
         ")->queryAll();

         return $stat[0]["ss"];
    }
    
    public function sumGoalsPersent() {
        
        If (!$this->sumGoalsAll()) return 0;
        return ceil($this->sumGoals()*100/$this->sumGoalsAll());
    }
}
