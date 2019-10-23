<?php

namespace app\models;

use Yii;
use yii\helpers\Html;
//use app\models\Field;

/**
 * This is the model class for table "{{%game}}".
 *
 * @property integer $id
 * @property integer $turnir_id
 * @property integer $etap_id
 * @property integer $tur
 * @property integer $pole_id
 * @property string $date
 * @property string $time
 * @property integer $ref_id
 * @property integer $ref2_id
 * @property integer $team1
 * @property integer $team2
 * @property integer $gol1
 * @property integer $gol2
 * @property integer $pen1
 * @property integer $pen2
 */
class Game extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%game}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['turnir_id', 'etap_id', 'tur', 'tur_time_id', 'field_id', 'ref_id', 'ref2_id', 'kom_id', 'team1_id', 'team2_id', 'gol1', 'gol2', 'pen1', 'pen2', 'tehn1', 'tehn2', 'protocol'], 'integer'],
            [['date', 'time'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'turnir_id' => 'Турнир',
            'etap_id' => 'Этап',
            'tur' => 'Тур',
            'field_id' => 'Площадка',
            'date' => 'Дата',
            'time' => 'Время',
            'ref_id' => 'Первый судья',
            'ref2_id' => 'Второй судья',
            'kom_id' => 'Комиссар',
            'team1_id' => 'Команда 1',
            'team2_id' => 'Команда 2',
            'gol1' => 'Голы 1',
            'gol2' => 'Голы 2',
            'pen1' => 'Пенальти 1',
            'pen2' => 'Пенальти 2',
            'tehn1' => 'Техническое поражение',
            'tehn2' => 'Техническое поражение',
        ];
    }
    
    public static function findFromTurnirTable($ttable1, $ttable2) {
        $etap_id =  $ttable1->turnirTeam->turnirEtap->id;
        return Game::find()->where("
            gol1 IS NOT NULL AND gol2 IS NOT NULL AND 
            etap_id = $etap_id AND 
            (team1_id = $ttable1->team_id AND team2_id = $ttable2->team_id 
            OR 
            team2_id = $ttable1->team_id AND team1_id = $ttable2->team_id)
        ")->one();
    }
    
    public function getLink() {
        return Html::a('<span class="glyphicon glyphicon-eye-open"></span> обзор', ['/game/'.$this->id]);
    }
    public function getTeam1()
    {
        return $this->hasOne(Team::className(), ['id' => 'team1_id']);
    }
    
    public function getTeam2()
    {
        return $this->hasOne(Team::className(), ['id' => 'team2_id']);
    }
    
    public function getRef1()
    {
        return $this->hasOne(Profile::className(), ['id' => 'ref_id']);
    }
    
    public function getRef2()
    {
        return $this->hasOne(Profile::className(), ['id' => 'ref2_id']);
    }

    public function getKom()
    {
        return $this->hasOne(Profile::className(), ['id' => 'kom_id']);
    }
    
    public function getYourTeam()
    {
        If ($this->team1->creator == Yii::$app->user->identity->profile_id)
            return $this->team1;
        elseif ($this->team2->creator == Yii::$app->user->identity->profile_id)
            return $this->team2;
        else return null;
    }
    
    public function getRivalTeam()
    {
        If ($this->team1->creator == Yii::$app->user->identity->profile_id)
            return $this->team2;
        elseif ($this->team2->creator == Yii::$app->user->identity->profile_id)
            return $this->team1;
        else return null;
    }
    
    public function getTeam1list()
    {
        If ($this->turDate)
                $date = $this->turDate->date;
            elseif ($this->date)
                $date = $this->date;
            else
                $date = null;
        
        //If (($this->turnir_id <> 813) OR (($this->team1_id <> 2) AND ($this->team1_id <> 1057)AND ($this->team1_id <> 32))) {
        If ($this->turnir_id <> 850)    {
            
            //die($date);
            
            //die(TeamList::tableName().'.date_in < "'.$date.'" AND '.TeamList::tableName().'.date_out >"'.$date.'"');
            If ($date)
                return TeamList::find()
                    ->where([
                        TeamList::tableName().'.turnir_id' => $this->turnir_id, 
                        TeamList::tableName().'.team_id' => $this->team1_id,
                    ])->andWhere(
                        TeamList::tableName().'.date_in < "'.$date.'" AND '.TeamList::tableName().'.date_out >"'.$date.'"'
                    )->joinWith('profile')
                    ->orderBy(Profile::tableName().'.lname')
                    ->All();
            else return [];
        }
       /*elseif ((($this->turnir_id == 819) AND (($this->team1_id == 2) OR ($this->team1_id == 1057) OR ($this->team1_id == 32))) OR ($this->turnir_id == 813)) */
        elseif ($this->turnir_id == 850)
            return TeamList::find()
                ->where([
                    TeamList::tableName().'.turnir_id' => [845,846,847,848,849], 
                    TeamList::tableName().'.team_id' => $this->team1_id,
                ])->andWhere(
                        TeamList::tableName().'.date_in < "'.$date.'" AND '.TeamList::tableName().'.date_out >"'.$date.'"'
                )->joinWith('profile')
                ->orderBy(Profile::tableName().'.lname')
                ->All();
        /*else 
            return TeamList::find()
                ->where([
                    TeamList::tableName().'.turnir_id' => [16,17,18], 
                    TeamList::tableName().'.team_id' => $this->team1_id,
                ])->andWhere(
                        TeamList::tableName().'.date_in < "'.$date.'" AND '.TeamList::tableName().'.date_out >"'.$date.'"'
                )->joinWith('profile')
                ->orderBy(Profile::tableName().'.lname')
                ->All();*/
    }
    public function getTeam2list()
    {
        If ($this->turDate)
                $date = $this->turDate->date;
            elseif ($this->date)
                $date = $this->date;
            else
                $date = null;
                
        //If ((($this->turnir_id <> 819) OR (($this->team2_id <> 2) AND ($this->team2_id <> 1057)AND ($this->team2_id <> 32)))) {
        If ($this->turnir_id <> 850) {
            If ($date)
                return TeamList::find()
                    ->where([
                        TeamList::tableName().'.turnir_id' => $this->turnir_id, 
                        TeamList::tableName().'.team_id' => $this->team2_id,
                    ])->andWhere(
                        TeamList::tableName().'.date_in < "'.$date.'" AND '.TeamList::tableName().'.date_out >"'.$date.'"'
                    )->joinWith('profile')
                    ->orderBy(Profile::tableName().'.lname')
                    ->All();
            else return [];
        }
        /*elseif ((($this->turnir_id == 819) AND (($this->team2_id == 2) OR ($this->team2_id == 1057) OR ($this->team2_id == 32))) OR ($this->turnir_id == 813)) */
        elseif ($this->turnir_id == 850)
            return TeamList::find()
                ->where([
                    TeamList::tableName().'.turnir_id' => [845,846,847,848,849], 
                    TeamList::tableName().'.team_id' => $this->team2_id,
                ])->andWhere(
                        TeamList::tableName().'.date_in < "'.$date.'" AND '.TeamList::tableName().'.date_out >"2015-10-31"'
                )->joinWith('profile')
                ->orderBy(Profile::tableName().'.lname')
                ->All();
        /*else 
            return TeamList::find()
                ->where([
                    TeamList::tableName().'.turnir_id' => [17,18,16], 
                    TeamList::tableName().'.team_id' => $this->team2_id,
                ])->andWhere(
                        TeamList::tableName().'.date_in < "'.$date.'" AND '.TeamList::tableName().'.date_out >"'.$date.'"'
                )->joinWith('profile')
                ->orderBy(Profile::tableName().'.lname')
                ->All(); 
            */
    }
    
    public function getTurnirTeam1()
    {
        return $this->hasOne(TurnirTeam::className(), ['team_id' => 'team1_id'])
        ->where(
            ['and',
                ['turnir_id' => $this->turnir_id], 
                ['etap_id' => $this->etap_id]
            ]
        );
    }
    
    public function getTurnirTeam2()
    {
        return $this->hasOne(TurnirTeam::className(), ['team_id' => 'team2_id'])
        ->where(
            ['and',
                ['turnir_id' => $this->turnir_id], 
                ['etap_id' => $this->etap_id]
            ]
        );
    }
    
    public function getTurnir()
    {
        return $this->hasOne(Turnir::className(), ['id' => 'turnir_id']);
    }
    
    public function getField()
    {
        return $this->hasOne(Field::className(), ['id' => 'field_id']);
    }
    
    public function getEtap()
    {
        return $this->hasOne(TurnirEtap::className(), ['id' => 'etap_id']);
    }
    
    public function getStat()
    {
        return $this->hasMany(Statistic::className(), ['game_id' => 'id'])->orderBy('goals DESC, cards DESC');
    }
    
    public function getGolStat()
    {
        return Statistic::find()->where(['game_id' => $this->id])->sum('goals');
    }
    
    public function getStatusStat()
    {
        if ($this->haveGols())
            return ($this->golStat == ($this->gol1+$this->gol2)) OR $this->tehn1 OR $this->tehn2;
        return false;
    }
    
    public function getBedStat()
    {
        if ($this->haveGols() AND $this->golStat AND ($this->golStat != ($this->gol1+$this->gol2)))
            return true;
        return false;
    }
    
    public function getNoStat()
    {
        if ($this->haveGols() AND (count($this->stat) == 0))
            return true;
        return false;
    }
    
    public function haveGols() {
        return (!is_null($this->gol1) AND !is_null($this->gol1));
    }
    
    public function winner() {
        
        If ($this->tehn1 AND !$this->tehn2)
            return $this->team2;
        If ($this->tehn2 AND !$this->tehn1)
            return $this->team1;
            
        If ($this->gol1 > $this->gol2)
            return $this->team1;
        elseif ($this->gol2 > $this->gol1)
            return $this->team2;
        else {
            If ($this->pen1 > $this->pen2)
                return $this->team1;
            elseIf ($this->pen2 > $this->pen1)
                return $this->team2;
        }
        
        return null;
    }

    public function looser() {
        
        If ($this->tehn1 AND !$this->tehn2)
            return $this->team1;
        If ($this->tehn2 AND !$this->tehn1)
            return $this->team2;
            
        If ($this->gol1 > $this->gol2)
            return $this->team2;
        elseif ($this->gol2 > $this->gol1)
            return $this->team1;
        else {
            If ($this->pen1 > $this->pen2)
                return $this->team2;
            elseIf ($this->pen2 > $this->pen1)
                return $this->team1;
        }
        
        return null;
    }

    public function getTurDate() {
        return $this->hasOne(TurDate::className(), [
            'etap_id' => 'etap_id',
            'tur' => 'tur',
        ]);
    }
    
    public function getChooseTeams() {
        $chooses = [];
        foreach ($this->turDate->turTime as $time) {
            
            $t1ch = Choose::find()->where([
                'tur_time_id' => $time->id,
                'team_id' => $this->team1_id,
            ])->one();
            $t2ch = Choose::find()->where([
                'tur_time_id' => $time->id,
                'team_id' => $this->team2_id,
            ])->one();
            $text = $t1ch->choose.'-'.$t2ch->choose;
            
            If (is_null($t1ch->choose)) $t1ch_int = 1;
            else $t1ch_int = $t1ch->choose;
            If (is_null($t2ch->choose)) $t2ch_int = 1;
            else $t2ch_int = $t2ch->choose;
            
            $sum = $t1ch_int + $t2ch_int;
            $mn = $t1ch_int*$t2ch_int;
            If ($mn == 0) $color = '#ff9696';
            elseif ($sum == 4) $color = '#98ff96';
            else $color = '#f6ff96';
            
            If ($this->tur_time_id == $time->id) $class = "border";
            else $class = "";
            $chooses[$time->time] = '
                <p class="chooses_val '.$class.'" data-toggle="tooltip" title="'.$time->time.'" name="'.$time->id.'" style="
                    display: inline-block; 
                    width: 30px; 
                    background-color: '.$color.';
                    text-align: center;
                ">'
                    .$text.
                '</p>';
        }

        $chooses[0] = '
                <p class="chooses_val '.$class.'" data-toggle="tooltip" title="убрать" name="0" style="
                    display: inline-block; 
                    width: 30px; 
                    background-color: grey;
                    text-align: center;
                ">
                    0</p> '.$this->turDate->date.' ('.$this->turDate->field->name.')';
        return $chooses;
    }
    
    public function ChooseForUpdate() {
        $chooses = [];
        Foreach ($this->turDate->turTime as $time) {
            If (!$choose = Choose::find()->where([
                'tur_time_id' => $time->id,
                'team_id' => $this->yourTeam->id,
            ])->one()) {
                $choose = new Choose();
                $choose->team_id = $this->yourTeam->id;
                $choose->tur_time_id = $time->id;
            }
            $chooses[] = $choose;
            
        }
        return $chooses;
    }
    
    public function getDateFormat() {
        Switch (substr($this->date,5,2)) {
            case '01': $month = 'января'; break;
            case '02': $month = 'февраля'; break;
            case '03': $month = 'марта'; break;
            case '04': $month = 'апреля'; break;
            case '05': $month = 'мая'; break;
            case '06': $month = 'июня'; break;
            case '07': $month = 'июля'; break;
            case '08': $month = 'августа'; break;
            case '09': $month = 'сентября'; break;
            case '10': $month = 'октября'; break;
            case '11': $month = 'ноября'; break;
            case '12': $month = 'декабря'; break;
            
        }
        return substr($this->date,8,2).' '.$month;
    }
    
    public function getDateFormatY() {
        
        return $this->dateFormat.' '.substr($this->date,0,4);
    }
    
    public function getTimeFormat() {
        
        return substr($this->time,0,5);
    }
    
    public function getOldGames() {
        
        return Game::find()->where('
            team1_id = '.$this->team1_id.' AND  team2_id = '.$this->team2_id.' OR
            team1_id = '.$this->team2_id.' AND  team2_id = '.$this->team1_id
        )->All();
    }
    
    public function getOldGameBD() {
        
        return $this->hasOne(Games::className(), ['id' => 'id']);
    }
    
    public function resetDate() {
        $this->date = null;
        $this->time = null;
        $this->field_id = null;
        $this->tur_time_id = null;
        $this->save();
    }

}
