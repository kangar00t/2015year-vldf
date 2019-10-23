<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%statistic}}".
 *
 * @property integer $id
 * @property integer $game_id
 * @property integer $team_id
 * @property integer $profile_id
 * @property integer $goals
 * @property integer $cards
 * @property integer $editor_id
 * @property integer $is_best
 */
class Statistic extends \yii\db\ActiveRecord
{
    public $isLoad = 1;
    static public function cardsImgMas() {
        return    
        [
            '1' => '<img src="/img/zh_k.png" width="20px" />',
            '3' => '<img src="/img/red_k.png" width="20px" />',
            '2' => '<img src="/img/2zh_k.png" width="20px" />',
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%statistic}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['game_id', 'team_id', 'profile_id'], 'required'],
            [['game_id', 'team_id', 'profile_id', 'goals', 'cards', 'editor_id', 'is_best', 'isLoad'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'game_id' => 'Game ID',
            'team_id' => 'Team ID',
            'profile_id' => 'Profile ID',
            'goals' => 'Goals',
            'cards' => 'Cards',
            'editor_id' => 'Editor ID',
            'is_best' => '',
            'isLoad' => '',
        ];
    }
    
    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['id' => 'profile_id']);
    }
    
    public function getGame()
    {
        return $this->hasOne(Game::className(), ['id' => 'game_id']);
    }
    
    public function getCardsImg()
    {
        Switch ($this->cards) {
            Case 1:
                return Statistic::cardsImgMas()[1]; 
                break;
            Case 2:
                return Statistic::cardsImgMas()[2];
                break;
            Case 3:
                return Statistic::cardsImgMas()[3];
                break;
        }
        return '';
        
    }
}
