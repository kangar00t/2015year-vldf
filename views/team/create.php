<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\models\Team */

$this->title = 'Создание команды';
?>
<div class="team-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="team-form">

        <?php $form = ActiveForm::begin(); ?>
    
        <?= $form->field($model, 'name')->textInput(['maxlength' => 64]) ?>
        
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    
        <?php ActiveForm::end(); ?>
    
    </div>

</div>
