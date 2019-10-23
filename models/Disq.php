<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vldf_disq".
 *
 * @property integer $id
 * @property integer $profile_id
 * @property string $text
 * @property integer $status
 */
class Disq extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vldf_disq';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['profile_id', 'text', 'status'], 'required'],
            [['profile_id', 'status'], 'integer'],
            [['text'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'profile_id' => 'Икрок (ID)',
            'text' => 'Описание',
            'status' => 'Статус',
        ];
    }

    public function getStatusArray()
    {
        return [
            '0' => 'На рассмотрении',
            '1' => 'Действует',
            '2' => 'Завершена',
        ];
    }

    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['id' => 'profile_id']);
    }
}
