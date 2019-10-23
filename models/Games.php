<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%games}}".
 *
 * @property integer $id
 * @property integer $turnir_id
 * @property integer $etap_id
 * @property integer $tur
 * @property integer $field_id
 * @property string $date
 * @property string $time
 * @property integer $tur_time_id
 * @property integer $ref_id
 * @property integer $ref2_id
 * @property integer $team1_id
 * @property integer $team2_id
 * @property integer $gol1
 * @property integer $gol2
 * @property integer $pen1
 * @property integer $pen2
 * @property integer $tehn1
 * @property integer $tehn2
 * @property integer $etap_old
 * @property integer $protocol
 */
class Games extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%games}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['turnir_id', 'etap_id', 'tur', 'field_id', 'tur_time_id', 'ref_id', 'ref2_id', 'team1_id', 'team2_id', 'gol1', 'gol2', 'pen1', 'pen2', 'tehn1', 'tehn2', 'etap_old', 'protocol'], 'integer'],
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
            'turnir_id' => 'Turnir ID',
            'etap_id' => 'Etap ID',
            'tur' => 'Tur',
            'field_id' => 'Field ID',
            'date' => 'Date',
            'time' => 'Time',
            'tur_time_id' => 'Tur Time ID',
            'ref_id' => 'Ref ID',
            'ref2_id' => 'Ref2 ID',
            'team1_id' => 'Team1 ID',
            'team2_id' => 'Team2 ID',
            'gol1' => 'Gol1',
            'gol2' => 'Gol2',
            'pen1' => 'Pen1',
            'pen2' => 'Pen2',
            'tehn1' => 'Tehn1',
            'tehn2' => 'Tehn2',
            'etap_old' => 'Etap Old',
            'protocol' => 'Protocol',
        ];
    }
}
