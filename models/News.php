<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%new}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $text
 * @property string $image
 * @property integer $status
 * @property integer $creator_id
 * @property integer $created_at
 * @property integer $public_at
 */
class News extends \yii\db\ActiveRecord
{
    
    public $logo3;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%new}}';
    }

    public static function resetMain() {
        return self::updateAll(['status' => 1], ['status' => 3]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'text', 'status', 'creator_id', 'created_at'], 'required'],
            [['text'], 'string'],
            [['status', 'creator_id'], 'integer'],
            [['created_at', 'public_at'], 'date', 'format' => 'yyyy-M-d H:m:s'],
            [['title', 'image'], 'string', 'max' => 255],            
            [['logo3'], 'image',  'extensions' => 'png,jpg', 'skipOnEmpty' => true], 
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'text' => 'Текст',
            'image' => 'Картинка',
            'status' => 'Статус',
            'creator_id' => 'Автор',
            'created_at' => 'Время написания',
            'public_at' => 'Время публикации',
        ];
    }
    
    Public function getTextShot() {
        //If (mb_strlen($this->text) > 500) return mb_substr($this->text, 0, 500);
        return $this->text;
    }
}
