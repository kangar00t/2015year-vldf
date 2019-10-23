<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%turnir_team}}".
 *
 * @property integer $id
 * @property integer $turnir_id
 * @property integer $team_id
 * @property integer $status
 * @property integer $updated_at
 */
class TurnirTeam extends \yii\db\ActiveRecord
{
    
    const STATUS_BLOCKED = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_WAIT = 2;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%turnir_team}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['turnir_id', 'team_id', 'status'], 'required'],
            [['turnir_id', 'team_id', 'status', 'etap_id', 'stage_id', 'position', 'updated_at', 'test'], 'integer']
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
            'team_id' => 'Team ID',
            'status' => 'Status',
            'updated_at' => 'Updated At',
        ];
    }
    
    public function getTurnir()
    {
        return $this->hasOne(Turnir::className(), ['id' => 'turnir_id']);
    }
    
    public function getTeam()
    {
        return $this->hasOne(Team::className(), ['id' => 'team_id']);
    }
    
    public function getTurnirEtap()
    {
        return $this->hasOne(TurnirEtap::className(), ['id' => 'etap_id']);
    }
    
    public function getTurnirTable()
    {
        return $this->hasOne(TurnirTable::className(), ['tteam_id' => 'id']);
    }
    
    public function getGames()
    {
        return $this->hasMany(Game::className(), ['etap_id' => 'etap_id'])
        ->where(
            ['or', 
                ['team1_id' => $this->team_id], 
                ['team2_id' => $this->team_id]
            ]
        );
    }
    
    public function getGames10()
    {
        return $this->hasMany(Game::className(), ['etap_id' => 'etap_id'])
        ->where(
            ['or', 
                ['team1_id' => $this->team_id], 
                ['team2_id' => $this->team_id]
            ]
        )->andWhere('tur < 11');
    }
    
    public function getTeamList()
    {
        return $this->hasMany(TeamList::className(), ['tteam_id' => 'id'])->joinWith('profile')
            ->orderBy(Profile::tableName().'.lname');
    }
    
    public function getTeamListNow()
    {
        return $this->hasMany(TeamList::className(), ['tteam_id' => 'id'])->andWhere('date_out > now()')->andWhere('date_out > '.$this->turnir->started_at )->joinWith('profile')
            ->orderBy(Profile::tableName().'.lname');
    }
    
    public function getTeamListAdded()
    {
        return $this->hasMany(TeamList::className(), ['tteam_id' => 'id'])->where(['added' => 1]);
    }
    
    public function getTeamListNoDoc()
    {
        return $this->hasMany(TeamList::className(), ['tteam_id' => 'id'])->joinWith('profile')
            ->where([Profile::tableName().'.status' => 0]);
    }
    public function getTeamListAddedCount()
    {
        $count = 0;
        foreach (TeamList::find()
            ->where(['tteam_id' => $this->id])
            //->andWhere('date_out > now()')
            ->All() as $tlist) {
            if (($tlist->date_in > $this->turnir->started_at)
                AND ($tlist->date_in > '2017-01-27' OR $tlist->date_in < '2017-01-23') 
                AND ($tlist->date_out > $this->turnir->ended_at) 
                AND ( count($tlist->statGameAll()) > 0 OR $tlist->date_out > $tteam->turnir->enden_at))
                $count++;
        }
        return $count;
    }
}
