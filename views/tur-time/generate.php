<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\TurTime */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tur-time-form">
    
    <? //var_dump($turdates) ?>
    <? //die() ?>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tur_date_id')->dropDownList(ArrayHelper::map($turdates, 'id', function ($element) {
            return $element->turnirEtap->turnir->name.' - '.$element->tur.' тур ('.$element->turnirEtap->id.')';
        })); ?>
    <? foreach ($model->time_array as $time) : ?>
        <p><?= $time; ?></p>
    <? endforeach; ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>