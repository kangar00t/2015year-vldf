<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Field */

$this->title = $model->name;
?>
<div class="field-view">
    <div class="col-md-3">
        <?= $model->LogoImg(200);?>
    </div>
    <div class="col-md-9">
        <h1><?= Html::encode($this->title) ?></h1>

        <p>
        <? If (Yii::$app->user->can('admin')) : ?>
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        <? endif; ?>  

            <p>Протоколы с площадки</p>
            <p>Выберите даты игр:</p>
            <?php $form = ActiveForm::begin(); ?>
                        <?= $form->field($game, 'date')->widget(
                            DatePicker::className(),
                            [
                              'language' => 'ru',
                              'clientOptions' => [
                                'changeYear' => true,
                                'changeMonth' => true,
                                'yearRange' => "2000:2025"
                              ],
                              'dateFormat' => 'yyyy-MM-dd',
                            ]
                        ); ?>
            <?php ActiveForm::end(); ?>

            <?= Html::a('Печать протокола', ['/game/protocol-field', 'id' => $model->id, 'date' => '2016-05-14'], ['class' => 'btn-primary print-btn']) ?>
        </p>
        <? if ($model->map) :?>
        <p>
            Схема проезда:        
            <?= $model->map;?>
        </p>
        <? endif; ?>
        
    </div>
   
</div>

<? $this->registerJs('
    $("#game-date").change(function() {
        var date = $(this).val();
        console.log(date);
        $(".print-btn").attr("href", "/game/protocol-field/'.$model->id.'?date="+date).show();
    })
');
?>