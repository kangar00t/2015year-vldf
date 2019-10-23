<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Turnir */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="turnir-form">

    <?php $form = ActiveForm::begin([
                'layout' => 'horizontal',
            ]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'shotname')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'started_at')->textInput() ?>

    <?= $form->field($model, 'ended_at')->textInput() ?>

    <?= $form->field($model, 'stage')->textInput(); ?>

    <?= $form->field($model, 'creator')->dropDownList(ArrayHelper::map($creators, 'id', 'name')); ?>

    <?= $form->field($model, 'status')->dropDownList([0 => 'Новый', 1=> 'Набор команд', 2=>'Идет', 3=>'Окончен', 9=>'Удален']); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
