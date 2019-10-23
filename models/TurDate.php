<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%tur_date}}".
 *
 * @property integer $id
 * @property integer $etap_id
 * @property integer $tur
 * @property string $date
 * @property integer $field_id
 */
class TurDate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tur_date}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['etap_id', 'tur'], 'required'],
            [['etap_id', 'tur', 'field_id'], 'integer'],
            [['date'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'etap_id' => 'Этап Турнира',
            'tur' => 'Тур',
            'date' => 'Дата',
            'field_id' => 'Площадка',
        ];
    }
    
    public function getTurnirEtap()
    {
        return $this->hasOne(TurnirEtap::className(), ['id' => 'etap_id']);
    } 
    
    public function getGames() {
        return $this->hasMany(Game::className(),[
            'etap_id' => 'etap_id',
            'tur' => 'tur',
        ]);
    }
    
    public function getTurTime() {
        return $this->hasMany(TurTime::className(),[
            'tur_date_id' => 'id',
        ])->orderBy('id');
    }
    
    public function getField()
    {
        return $this->hasOne(Field::className(), ['id' => 'field_id']);
    } 
    
}
