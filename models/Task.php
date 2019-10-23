<?php

namespace app\models;

use Yii;
use yii\helpers\Html;

/**
 * This is the model class for table "{{%task}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $text
 * @property string $date_in
 * @property string $date_out
 * @property string $date_stop
 * @property integer $status
 * @property integer $creator
 * @property integer $performer
 * @property integer $parent
 */
class Task extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%task}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    { 
        return [
            [['name', 'text', 'date_in', 'status', 'creator', 'parent'], 'required'],
            [['text'], 'string'],
            [['date_in', 'date_out', 'date_stop'], 'safe'],
            [['status', 'creator', 'performer', 'parent'], 'integer'],
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
            'name' => 'Заголовок',
            'text' => 'Описание',
            'date_in' => 'Создана',
            'date_out' => 'Срок',
            'date_stop' => 'Исполнена',
            'status' => 'Статус',
            'creator' => 'Создатель',
            'performer' => 'Исполнитель',
            'parent' => 'Главная задача',
        ];
    }
    
    public function getStatusArray() {
        
        return [
            '1' => 'Ожидает назначения',
            '2' => 'Назначена',
            '3' => 'Завершена',
            '4' => 'Отклонена',
            '5' => 'Удалена',
            '6' => 'Требует обсуждения',
        ];
    }
    
    public function getTasks() {
        return $this->hasMany(Task::className(), ['parent' => 'id']);
    }
    
    public function getParentTasks() {
        $model = $this;
        $ptasks = [];
        
        While ($model->parent) {
            $model = Task::findOne($model->parent);
            $ptasks[] = $model;
        }
        return array_reverse($ptasks);
    }
    
    public function getUserCreator() {
        return $this->hasOne(User::className(), ['id' => 'creator']);
    }
    
    public function getUserPerformer() {
        return $this->hasOne(User::className(), ['id' => 'performer']);
    }
    
    public function haveTasks() {
        return (count($this->tasks)) ? true:false;
    }
    
    public function getLink()
    {
        return Html::a($this->name, ['/task/'.$this->id], ['class' => '']);
    }
    
    public function diffDate() {
        if ($this->date_out) {
            $date = new \DateTime($this->date_out);
            $ndate = new \DateTime;
            $interval = $date->diff($ndate);
            return $interval->format('%R%a дней');;
        } else
            return null;
    }
    
    public function showDateOut() {
        if ($this->date_out) {
            $date = new \DateTime($this->date_out);
            $ndate = new \DateTime;
            If ($date<$ndate)
                return '<span style="color:red;">'.$date->format('d M').'</span> ';
            else 
                return '<span style="color:green;">'.$date->format('d M').'</span> ';
        }
        else return '<span style="color:grey;">без срока</span> ';
    }
}
