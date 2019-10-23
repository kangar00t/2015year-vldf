<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%referee}}".
 *
 * @property integer $id
 * @property integer $profile_id
 * @property integer $status
 * @property integer $level
 */
class Referee extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%referee}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['profile_id', 'status', 'level'], 'required'],
            [['profile_id', 'status', 'level'], 'integer']
        ];
    }

    public static function findOrderGames() {
        Referee::find()
            ->select('vldf_referee.profile_id , count(`vldf_game`.`id`) as count')
            ->innerJoin('vldf_game')
            ->where('vldf_game'.'.ref_id = vldf_referee.profile_id')
            ->orderBy('count')
            ->groupBy('vldf_game'.'.id')
            ->All();
    }
    
    public function fields()
    {
        return [
            'lname' => function () {
                return $this->profile->lname;
            },
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
            'status' => 'Status',
            'level' => 'Level',
        ];
    }
    
    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['id' => 'profile_id']);
    }
    
    public function getGames()
    {
        return Game::find()
        ->where([
            'or', 
            ['ref_id' => $this->profile_id], 
            ['ref2_id' => $this->profile_id]])
        ->andWhere(['>','turnir_id', 824])
        ->All();
    }
}
