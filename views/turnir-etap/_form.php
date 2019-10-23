<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\TurnirEtap */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="turnir-etap-form">
    <?php $form = ActiveForm::begin([
                'layout' => 'horizontal',
                'id' => 'add-etap',
                'enableAjaxValidation' => false,
            ]);  ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]); ?>
    <?= $form->field($model, 'type')->dropDownList(ArrayHelper::map($types, 'id', 'name')); ?>
    <?= $form->field($model, 'stage_id')->dropDownList(ArrayHelper::map($turnir->stages, 'id', 'sort')); ?>
    <?= $form->field($model, 'size')->textInput(); ?>
    <?= $form->field($model, 'steps')->dropDownList(['1' => '1', '2' => '2']); ?>
    <?= $form->field($model, 'sort')->textInput(); ?>
    <?= $form->field($model, 'game3')->dropDownList([0 => 'Нет', 1 => 'Да']); ?>
    <?= $form->field($model, 'turnir_id')->hiddenInput(['value' => $turnir->id])->label(false); ?>
    

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
