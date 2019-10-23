<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%assn}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $creator
 * @property integer $status
 */
class Assn extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%assn}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'creator', 'status'], 'required'],
            [['creator', 'status'], 'integer'],
            [['name'], 'string', 'max' => 255]
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
            'creator' => 'Creator',
            'status' => 'Status',
        ];
    }
}
