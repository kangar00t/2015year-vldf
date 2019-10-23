<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\TurDate */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tur-date-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'etap_id')->dropDownList(ArrayHelper::map($etaps, 'id', function ($element) {
            return $element->turnir->name.' ('.$element->id.')';
        })); ?>

    <?= $form->field($model, 'tur')->textInput() ?>

    <?= $form->field($model, 'date')->widget(
            DatePicker::className(),
            [
              'language' => 'ru',
              'clientOptions' => [
                'changeYear' => true,
                'changeMonth' => true,
                'yearRange' => "2016:2026"
              ],
              'dateFormat' => 'yyyy-MM-dd',
            ]
        ) ?>

    <?= $form->field($model, 'field_id')->dropDownList(ArrayHelper::map($fields, 'id', 'name')); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить изменения', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
