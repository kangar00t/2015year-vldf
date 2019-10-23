<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\TeamList */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="team-list-form">
    <p name="add-tlist">Добавление игрока</p>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($profile, 'lname')->textInput(['class' => 'add-player']) ?>

    <?= $form->field($profile, 'fname')->textInput(['class' => 'add-player']) ?>

    <?= $form->field($profile, 'sname')->textInput(['class' => 'add-player']) ?>

    <?= $form->field($profile, 'birthday')->widget(
            DatePicker::className(),
            [
              'language' => 'ru',
              'clientOptions' => [
                'changeYear' => true,
                'changeMonth' => true,
                'yearRange' => "1955:2008"
              ],
              'dateFormat' => 'yyyy-MM-dd',
            ]
        ) ?>
    

    <?= $form->field($model, 'profile_id')->textInput(['placeholder' => 'Сюда ничего не вводить']) ?>
    Новый игрок (поставьте галочку ниже, если вы не смогли найти игрока или не уверены, что в списке отображается именно он)
    <?= $form->field($model, 'new')->checkbox(['class' => 'add-player-new'])->label(false); ?>

    <?= $form->field($model, 'tteam_id')->hiddenInput()->label(false); ?>

    <?= $form->field($model, 'turnir_id')->hiddenInput()->label(false); ?>

    <?= $form->field($model, 'team_id')->hiddenInput()->label(false); ?>

    <? if (Yii::$app->user->can("admin")) : ?>
    <?= $form->field($model, 'date_in')->widget(
            DatePicker::className(),
            [
              'language' => 'ru',
              'clientOptions' => [
                'changeYear' => true,
                'changeMonth' => true,
                'yearRange' => "2017:2027"
              ],
              'dateFormat' => 'yyyy-MM-dd',
            ]
        ) ?>
    <p>От <?=$turnir->date_in;?> до <?=$turnir->date_out;?></p>
    <? else : ?>
        <?= $form->field($model, 'date_in')->hiddenInput()->label(false); ?>
    <? endif; ?>


    <?= $form->field($model, 'date_out')->hiddenInput()->label(false); ?>

    <?= $form->field($model, 'type')->hiddenInput()->label(false); ?>

    <?= $form->field($model, 'player')->hiddenInput()->label(false); ?>

    <div class="form-group">
        <?= Html::submitButton('Добавить', ['class' => 'btn btn-success']) ?>
        <?= Html::resetButton('Сброс', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>