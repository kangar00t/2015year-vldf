<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%diary_cat}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $sort
 */
class DiaryCat extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%diary_cat}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'sort'], 'required'],
            [['sort'], 'integer'],
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
            'name' => 'Название',
            'sort' => 'Порядок',
        ];
    }
    public function getDiaries()
    {
        return $this->hasMany(Diary::className(), ['cat' => 'id'])->orderBy('id DESC');
    }
}
