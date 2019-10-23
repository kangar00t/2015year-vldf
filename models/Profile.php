<?php

namespace app\models;

use Yii;
use yii\helpers\Html;

/**
 * This is the model class for table "{{%profile}}".
 *
 * @property integer $id
 * @property string $fname
 * @property string $lname
 * @property string $sname
 * @property string $birthday
 * @property string $photo
 * @property string $phone
 * @property string $profile_is
 * @property integer $user_id
 */
class Profile extends \yii\db\ActiveRecord
{

    public $logo3;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%profile}}';
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['user'] = ['user_id'];
        $scenarios['player'] = ['fname', 'lname', 'birthday'];
        return $scenarios;
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fname', 'lname', 'birthday'], 'required', on => 'player'],
            [['user_id'], 'required', on => 'user'],
            [['birthday'], 'safe'],
            [['user_id', 'profile_is', 'phone', 'type','status'], 'integer'],
            [['fname', 'lname', 'sname', 'photo', 'avatar'], 'string', 'max' => 32],
            [['logo3'], 'image',  'extensions' => 'jpg', 'skipOnEmpty' => true],  
        ];
    }
    

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fname' => 'Имя',
            'lname' => 'Фамилия',
            'sname' => 'Отчество',
            'birthday' => 'Дата рождения',
            'photo' => 'Фото',
            'phone' => 'Телефон',
            'user_id' => 'User',
        ];
    }
    
    
    ///уже не нужное
    public static function findDouble() {
        return Profile::find()->where(['>', 'profile_is', 0])->andWhere(['type' => 11])->one();
    }
    ///уже не нужное
    public function getProfileIsModel() {
        return $this->hasOne(Profile::className(), ['id' => 'profile_is']);
    }
    ///уже не нужное
    public function getChildrenProfile() {
        return $this->hasMany(Profile::className(), ['profile_is' => 'id']);
    }
    
    
    public function getUser() {
        if ($this->user_id)
            return $this->hasOne(User::className(), ['id' => 'user_id']);
        return false;
    }
    


    public function getLink() {
        return Html::a($this->lname.' '.$this->fname, ['/profile/'.$this->id], ['style' => 'text-transform: capitalize;']);
    }
    
    public function getFullName() {
        If (!$this->lname AND !$this->fname AND !$this->sname) 
            return 'Профиль id: '.$this->id;
        else
            return $this->lname.' '.$this->fname.' '.$this->sname;
    }
    
    public function getFullLink() {
        return Html::a($this->fullName, ['/profile/'.$this->id], ['style' => 'text-transform: capitalize;']);
    }
    public function getFullLinkShot() {
        If ($this->sname)
            return Html::a($this->lname.' '.$this->fname.' '.substr($this->sname,0,1).'.', ['/profile/'.$this->id], ['style' => 'text-transform: capitalize;']);
        return $this->link;
    }
    public function Avatar($width = 100){
        return '<img src="/img/avatars/'.$this->photo.'.jpg" width="'.$width.'px"  class="img-thumbnail" />';
    }
    
    public function Avatar2($width = 100){
        return '<img src="/img/avatars2/'.$this->avatar.'" width="'.$width.'px"  class="img-thumbnail" />';
    }
    
    public function filled() {
        return $this->fname && $this->lname && $this->birthday;
    }
    
    public function getTeamsCreated() {
        return $this->hasMany(Team::className(), ['creator' => 'id']);
    }
    
    public function getTeamList() {
        return $this->hasOne(TeamList::className(), ['profile_id' => 'id']);
    }
    
    public function getTeamLists() {
        return $this->hasMany(TeamList::className(), ['profile_id' => 'id'])->where('tteam_id > 0')->orderBy('date_in DESC');
    }
    public function getTeamListsNow() {
        return TeamList::find()
        ->select('vldf_team_list.*')
        ->innerJoin('vldf_turnir tn', '`tn`.`id` = `vldf_team_list`.`turnir_id`')
        ->where(['tn.status' => [1,2], 'vldf_team_list.profile_id' => $this->id])
        ->All();
    }
    
    public function canUpdate() {
        foreach ($this->teamListsNow as $tlist) {
            If ($tlist->team->isYour) return true;
        }
        return false;
    }
    public function getReferee() {
        return $this->hasOne(Referee::className(), ['profile_id' => 'id']);
    }
    
    public function isRefGame($id) {
        //return false;
        $game = Game::findOne($id);
        return ($game->ref_id == $this->id) OR ($game->ref2_id == $this->id);
    }
    
    public function getStatistics() {
        return $this->hasMany(Statistic::className(), ['profile_id' => 'id']);
    }
    
    public function CardsImg($id) {
        $turnir = Turnir::findOne($id);
        
        $cards[1] = 0;
        $cards[2] = 0;
        $cards[3] = 0;
        
        $stats = Yii::$app->db->createCommand("
            SELECT 
                vldf_statistic.cards as ss 
            FROM vldf_statistic 
            INNER JOIN vldf_game
             WHERE 
                vldf_statistic.game_id=vldf_game.id AND 
                vldf_game.turnir_id=$id AND 
                vldf_statistic.cards>0 AND 
                vldf_statistic.profile_id=$this->id
         ")->queryAll();
        
        Foreach ($stats as $stat) {
            $cards[$stat['ss']]++;
        }
        
        $str = '';
        If ($cards[2]) $str .= $cards[2].Statistic::cardsImgMas()[2];
        If ($cards[3]) $str .= $cards[3].Statistic::cardsImgMas()[3];
        If ($cards[1]) $str .= $cards[1].Statistic::cardsImgMas()[1];
        return $str;
    }
    
    public function getRefGames() {
        return Game::find()->where("(date > '2016-11-11') AND (ref_id = $this->id OR ref2_id = $this->id)")->count();
    }
    
}
