<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%teams}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $rating
 * @property integer $divizion
 * @property string $pic
 * @property string $emblema
 * @property integer $status
 */
class Teams extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%teams}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'rating', 'divizion', 'status'], 'required'],
            [['rating', 'divizion', 'status'], 'integer'],
            [['name'], 'string', 'max' => 40],
            [['pic'], 'string', 'max' => 50],
            [['emblema'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'rating' => 'Rating',
            'divizion' => 'Divizion',
            'pic' => 'Pic',
            'emblema' => 'Emblema',
            'status' => 'Status',
        ];
    }
}
