<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%doc}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $status
 * @property integer $type
 * @property integer $type_id
 */
class Doc extends \yii\db\ActiveRecord
{

    public $doc;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%doc}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'text'], 'required'],
            [['status', 'type', 'type_id'], 'integer'],
            [['name'], 'string', 'max' => 32],
            [['text'], 'string', 'max' => 255],
            [['doc'], 'file',  'extensions' => 'doc, docx, pdf, xls, xlsx', 'skipOnEmpty' => true],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя файла',
            'text' => 'Название документа',
            'status' => 'Статус',
            'type' => 'Тип элемента',
            'type_id' => 'ID элемента',
        ];
    }
}
