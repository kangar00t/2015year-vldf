<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Referee */

$this->title = 'Create Referee';
$this->params['breadcrumbs'][] = ['label' => 'Referees', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="referee-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="referee-form">
    
        <?php $form = ActiveForm::begin(); ?>
    
        <?= $form->field($model, 'profile_id')->dropDownList(ArrayHelper::map($users, 'profile_id', function($element) {
            return $element->username.' ('.$element->status.') '.$element->profileModel->fullName;})); ?>
    
        <?= $form->field($model, 'status')->textInput() ?>
    
        <?= $form->field($model, 'level')->textInput() ?>
    
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    
        <?php ActiveForm::end(); ?>
    
    </div>

</div>
