<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\models\Game */

$this->title = 'Create Game';
$this->params['breadcrumbs'][] = ['label' => 'Games', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="game-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="game-form">

        <?php $form = ActiveForm::begin(); ?>
    
        <?= $form->field($model, 'turnir_id')->textInput() ?>
    
        <?= $form->field($model, 'etap_id')->textInput() ?>
    
        <?= $form->field($model, 'tur')->textInput() ?>
    
        <?= $form->field($model, 'field_id')->textInput() ?>
    
        <?= $form->field($model, 'date')->textInput() ?>
    
        <?= $form->field($model, 'time')->textInput() ?>
    
        <?= $form->field($model, 'ref_id')->textInput() ?>
    
        <?= $form->field($model, 'ref2_id')->textInput() ?>
    
        <?= $form->field($model, 'gol1')->textInput() ?>
    
        <?= $form->field($model, 'gol2')->textInput() ?>
    
        <?= $form->field($model, 'pen1')->textInput() ?>
    
        <?= $form->field($model, 'pen2')->textInput() ?>
    
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    
        <?php ActiveForm::end(); ?>
    
    </div>

</div>
