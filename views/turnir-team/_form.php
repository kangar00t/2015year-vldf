<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\TurnirTeam */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="turnir-team-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'turnir_id')->dropDownList(ArrayHelper::map($turnirs, 'id', 'name')); ?>

    <?= $form->field($model, 'team_id')->dropDownList(ArrayHelper::map($teams, 'id', 'nameId')); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
