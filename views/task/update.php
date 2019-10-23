<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Task */

?>
<div class="task-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="task-form">
    
        <?php $form = ActiveForm::begin(); ?>
        
        <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>
    
        <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>
        
        <?= $form->field($model, 'date_out')->widget(
            DatePicker::className(),
            [
              'language' => 'ru',
              'clientOptions' => [
                'changeYear' => true,
                'changeMonth' => true,
                'yearRange' => "2015:2025"
              ],
              'dateFormat' => 'yyyy-MM-dd',
            ]
        ) ?>
    
        <?= $form->field($model, 'performer')->dropDownList(
            ArrayHelper::map($users, 'id', 'username'),
            ['prompt' => 'не анзначен']    
        ); ?>
    
        <?= $form->field($model, 'status')->dropDownList($model->statusArray); ?>
        
        <?= $form->field($model, 'parent')->dropDownList(ArrayHelper::map($tasks, 'id', 'name')); ?>
        
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            <?= Html::a('Отмена', ['task/view/'.$model->id], ['class' => 'btn btn-default']) ?>
        </div>
    
        <?php ActiveForm::end(); ?>
    
    
    </div>
