<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model app\models\TurnirTeam */

$this->title = 'Команды турнира '.$turnir->link;
?>
<div class="col-md-6 col-xs-6">

    <h4><?= $this->title ?></h4>

    <div class="turnir-team-form">
    
        <?php $form = ActiveForm::begin(); ?>
    
        <?= $form->field($model, 'team_id')->dropDownList(ArrayHelper::map($teams, 'id', 'nameId')); ?>
    
        <div class="form-group">
            <?= Html::submitButton('Добавить', ['class' => 'btn btn-success']) ?>
        </div>
    
        <?php ActiveForm::end(); ?>
    
    </div>
</div>
<div class="col-md-6 col-xs-4">
    <?php foreach ($turnir->teams as $team) : ?>
        <p><?= $team->link; ?></p>
    <?php endforeach; ?> 
</div>  