<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%task_message}}".
 *
 * @property integer $id
 * @property integer $task_id
 * @property integer $user_id
 * @property string $text
 * @property string $date
 */
class TaskMessage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%task_message}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['task_id', 'user_id', 'text'], 'required'],
            [['task_id', 'user_id'], 'integer'],
            [['text'], 'string'],
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
            'task_id' => 'Task ID',
            'user_id' => 'User ID',
            'text' => 'Text',
            'date' => 'Date',
        ];
    }
    
    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
