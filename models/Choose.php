<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%choose}}".
 *
 * @property integer $id
 * @property integer $tur_time_id
 * @property integer $team_id
 * @property integer $choose
 */
class Choose extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%choose}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tur_time_id', 'team_id', 'choose'], 'required'],
            [['tur_time_id', 'team_id', 'choose'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tur_time_id' => 'Tur Time ID',
            'team_id' => 'Team ID',
            'choose' => 'Choose',
        ];
    }
    
    public function getTime()
    {
        return $this->hasOne(TurTime::className(), ['id' => 'tur_time_id']);
    }
    
    public function getChooseName() {
        Switch ($this->choose) {
            case 0:
                return 'Не можем';
                break;
            case 1:
                return 'Можем';
                break;
            case 2:
                return 'Хотим';
                break;
        }
    }
    
}
