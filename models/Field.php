<?php

namespace app\models;

use Yii;
use yii\helpers\Html;

/**
 * This is the model class for table "{{%field}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $address
 * @property integer $phone
 * @property string $map
 * @property string $img
 * @property integer $status
 * @property integer $length
 * @property integer $width
 * @property integer $gale_width
 * @property integer $gate_height
 * @property integer $type_cover
 * @property integer $type_room
 * @property integer $cost
 */
class Field extends \yii\db\ActiveRecord
{
    public $img3;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%field}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['address'], 'string'],
            [['phone', 'status', 'length', 'width', 'gale_width', 'gate_height', 'type_cover', 'type_room', 'cost'], 'integer'],
            [['name'], 'string', 'max' => 32],
            [['map', 'img'], 'string', 'max' => 255],
            [['img3'], 'image',  'extensions' => 'png,jpg', 'skipOnEmpty' => true],  
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
            'address' => 'Адрес',
            'phone' => 'Телефон',
            'map' => 'Карта',
            'img' => 'Картинка',
            'status' => 'Статус',
            'length' => 'Длинна',
            'width' => 'Ширина',
            'gale_width' => 'Ширина ворот',
            'gate_height' => 'Высота ворот',
            'type_cover' => 'Покрытие',
            'type_room' => 'Крытый',
            'cost' => 'Цена аренды',
        ];
    }
    
    public function getLink()
    {
        return Html::a($this->name, ['/field/'.$this->id], ['class' => 'team-link']);
    }
    
    public function LogoImg($width = 100)
    {
        If ($this->img)
            return '<img src="/img/fields/'.$this->img.'" width="'.$width.'px"/>';
        return '<img src="/img/fields/no_name.jpg" width="'.$width.'px"/>';
    }
}
