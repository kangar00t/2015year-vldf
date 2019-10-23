<?php

namespace app\models;

use Yii;
use yii\helpers\Html;

/**
 * This is the model class for table "{{%team}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $creator
 * @property integer $status
 */
class Team extends \yii\db\ActiveRecord
{

    public $logo3;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%team}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'creator', 'status'], 'required'],
            [['creator', 'status'], 'integer'],
            [['name'], 'string', 'max' => 64],
            [['logo'], 'string', 'max' => 128],
            [['logo2'], 'string', 'max' => 128],
            [['logo3'], 'image',  'extensions' => 'png,jpg', 'skipOnEmpty' => true],            
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
            'creator' => 'Создатель',
            'status' => 'Статус',
            'logo' => 'Эмблема',
        ];
    }
    
    public function getTurnirTeams()
    {
        return $this->hasMany(TurnirTeam::className(), ['team_id' => 'id']);
    }
    
    public function getTurnirTeamsOne()
    {
        return $this->hasMany(TurnirTeam::className(), ['team_id' => 'id'])
        ->joinWith('turnir')->where([TurnirTeam::tableName().'.stage_id' => null])->orderBy(Turnir::tableName().'.started_at DESC');
    }
    
    public function getCreatorModel()
    {
        return $this->hasOne(Profile::className(), ['id' => 'creator']);
    }
    public function getIsYour()
    {
        return (Yii::$app->user->can('admin') OR (Yii::$app->user->id AND (Yii::$app->user->identity->profile_id == $this->creator)));
        //return Yii::$app->user->can('admin');
    }
    
    public function getLink()
    {
        return Html::a($this->name, ['/team/'.$this->id], ['class' => 'team-link']);
    }
    public function SizeLink($size = 12)
    {
        return Html::a($this->name, ['/team/'.$this->id], ['class' => 'team-link', 'style' => 'font-size:'.$size.'px;']);
    }
    public function getLinkImg()
    {
        return $this->LogoImg(20).' '.$this->link;
    }
    public function getNameId()
    {
        return $this->name.' ('.$this->id.')';;
    }
    
    public function getTeams()
    {
        return $this->hasOne(Teams::className(), ['id' => 'id']);
    }
    public function LogoImg($width = 100)
    {
        If ($this->logo)
            return '<img src="/img/emblems/'.$this->logo.'" width="'.$width.'px"/>';
        return '<img src="/img/emblems/no_name.jpg" width="'.$width.'px"/>';
    }
    public function Logo2Img($width = 100)
    {
        If ($this->logo2)
            return '<img src="/img/logo/'.$this->logo2.'" width="'.$width.'px"/>';
        return '<img src="/img/emblems/no_name.jpg" width="'.$width.'px"/>';
    }
    public function getTeamListOld()
    {
        return $this->hasMany(TeamList::className(), ['team_id' => 'id'])->joinWith('profile')
        ->orderBy(Profile::tableName().'.lname')->groupBy(Profile::tableName().'.id');
    }
    
    public function getTeamLists() {
        
        return $this->hasMany(TeamList::className(), ['team_id' => 'id'])->joinWith('profile')
        ->where(['>', TeamList::tableName().'.tteam_id', 0])->orderBy(Profile::tableName().'.lname')->groupBy(Profile::tableName().'.id');;
    }
    
}
