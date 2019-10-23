<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%tur_time}}".
 *
 * @property integer $id
 * @property integer $tur_date_id
 * @property string $time
 * @property integer $type
 */
class TurTime extends \yii\db\ActiveRecord
{
    
   
  public $time_array = [/*
'19:01:00',
'20:01:00',
'21:01:00',
'09:00:00',*/
        '10:00:00',
        '11:00:00',
        '12:00:00',
        '13:00:00',
        '14:00:00',
        '15:00:00',
        '16:00:00',
        '17:00:00',
        '18:00:00',
        '19:00:00',/*
'20:00:00',
'21:00:00',*/
    ];
    
  /*public $time_array = [
        '10:00:00',
        '11:00:00',
        '12:00:00',
        '13:00:00',
        '14:00:00',
        '15:00:00',
        '16:00:00',
        '17:00:00',
        '18:00:00',
        '19:00:00',
    ];*/
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tur_time}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tur_date_id', 'time'], 'required'],
            [['tur_date_id', 'type'], 'integer'],
            [['time'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tur_date_id' => 'Tur Date ID',
            'time' => 'Time',
            'type' => 'Type',
        ];
    }
    
    public function getTurDate() {
        return $this->hasOne(TurDate::className(),[
            'id' => 'tur_date_id',
        ]);
    }
}
