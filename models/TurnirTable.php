<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%turnir_table}}".
 *
 * @property integer $id
 * @property integer $tteam_id
 * @property integer $turnir_id
 * @property integer $team_id
 * @property integer $poz
 * @property integer $igr
 * @property integer $pob
 * @property integer $nich
 * @property integer $por
 * @property integer $zab
 * @property integer $prop
 * @property integer $razn
 * @property integer $och
 * @property integer $lv
 * @property integer $lr
 */
class TurnirTable extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%turnir_table}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['turnir_id', 'team_id'], 'required'],
            [['tteam_id', 'turnir_id', 'team_id', 'poz', 'igr', 'pob', 'nich', 'por', 'zab', 'prop', 'razn', 'och', 'lv', 'lr'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tteam_id' => 'TurnirTeam ID',
            'turnir_id' => 'Turnir ID',
            'team_id' => 'Team ID',
            'poz' => 'Poz',
            'igr' => 'Igr',
            'pob' => 'Pob',
            'nich' => 'Nich',
            'por' => 'Por',
            'zab' => 'Zab',
            'prop' => 'Prop',
            'razn' => 'Razn',
            'och' => 'Och',
            'lv' => 'Lv',
            'lr' => 'Lr',
        ];
    }
    
    public function resetStat() 
    {
        $this->och = 0;
        $this->igr = 0;
        $this->pob = 0;
        $this->nich = 0;
        $this->por = 0;
        $this->zab = 0;
        $this->prop = 0;
        $this->razn = 0;
        $this->och = 0;
        $this->lv = 0;
        //$this->lr = 0;
        $this->save();
    }
    
    public function getTeam() 
    {
        return $this->hasOne(Team::className(), ['id' => 'team_id']);
    }
    
    public function getTurnirTeam()
    {
        return $this->hasOne(TurnirTeam::className(), ['id' => 'tteam_id']);
    }
    
    public function updateStat()
    {
        $this->resetStat();
        
        //foreach($this->turnirTeam->games10 as $game) {
        foreach($this->turnirTeam->games as $game) {
            
            //echo $game->id.':'.$game->gol1.'-'.$game->gol2.'<hr>';
            
            if ($game->haveGols()) {
                
                if ($this->team_id == $game->team1_id) {
                    
                    If ($game->gol1 > $game->gol2) {
                        $this->pob++;
                        $this->och += 3;
                    } elseif ($game->gol1 < $game->gol2) {
                        $this->por++;
                    } else {
                        $this->nich++;
                        $this->och += 1;
                    }
                    $this->igr++;
                    $this->zab += $game->gol1;
                    $this->prop += $game->gol2;
                    $this->razn = $this->zab - $this->prop;
                } 
                
                elseif ($this->team_id == $game->team2_id) {
                    
                    If ($game->gol2 > $game->gol1) {
                        $this->pob++;
                        $this->och += 3;
                    } elseif ($game->gol2 < $game->gol1) {
                        $this->por++;
                    } else {
                        $this->nich++;
                        $this->och += 1;
                    }
                    $this->igr++;
                    $this->zab += $game->gol2;
                    $this->prop += $game->gol1;
                    $this->razn = $this->zab - $this->prop;
                }
                
                $this->save();
            }            
        }
    }
}
