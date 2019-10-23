<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Referee */

$this->title = 'Update Referee: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Referees', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="referee-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="referee-form">
    
        <?php $form = ActiveForm::begin(); ?>
    
        <?= $form->field($model, 'profile_id')->textInput() ?>
    
        <?= $form->field($model, 'status')->textInput() ?>
    
        <?= $form->field($model, 'level')->textInput() ?>
    
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    
        <?php ActiveForm::end(); ?>
    
    </div>

</div>
