<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%diary}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $text
 * @property string $link
 * @property integer $cat
 */
class Diary extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%diary}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'link', 'cat'], 'required'],
            [['text'], 'string'],
            [['cat'], 'integer'],
            [['name', 'link'], 'string', 'max' => 255]
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
            'text' => 'Описание',
            'link' => 'Код вставки',
            'cat' => 'Категория',
        ];
    }
    public function getDiaryCat()
    {
        return $this->hasOne(DiaryCat::className(), ['id' => 'cat']);
    }
}
