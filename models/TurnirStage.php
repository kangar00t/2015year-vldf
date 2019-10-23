<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%turnir_stage}}".
 *
 * @property integer $id
 * @property integer $turnir_id
 * @property integer $sort
 * @property integer $name
 * @property integer $type
 */
class TurnirStage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%turnir_stage}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['turnir_id', 'sort'], 'required'],
            [['turnir_id', 'sort', 'name', 'type'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'turnir_id' => 'Turnir ID',
            'sort' => 'Sort',
            'name' => 'Name',
            'type' => 'Type',
        ];
    }
    
    public function getEtaps()
    {
        return $this->hasMany(TurnirEtap::className(), ['stage_id' => 'id'])->orderBy('sort');
    }
    
    public function getTurnirTeams()
    {
        return $this->hasMany(TurnirTeam::className(), ['stage_id' => 'id'])->joinWith('team')
        ->orderBy(Team::tableName().'.name');
    }
    
    public function isStaffed() {
        $staffed = count($this->etaps) ? TRUE : FALSE;
        Foreach ($this->etaps as $etap) {
            $staffed = $staffed && $etap->isStaffed() ? TRUE : FALSE; 
        }
        return $staffed;
    }
    
    public function isTable() {
        
        $staffed = count($this->etaps) ? TRUE : FALSE;
        Foreach ($this->etaps as $etap) {
            $staffed = $staffed && $etap->isTable() ? TRUE : FALSE; 
        }
        return $staffed;
    }

    public function haveGames()
    {
        foreach ($this->etaps as $etap) {
            If ($etap->type == 1) {
                If (count($etap->games)) {
                    return true;
                }
            }
        }
        return false;
    }
    
}
