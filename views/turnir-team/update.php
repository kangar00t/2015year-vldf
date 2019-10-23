<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TurnirTeam */

$this->title = 'Update Turnir Team: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Turnir Teams', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="turnir-team-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'teams' => $teams,
        'turnirs' => $turnirs,
    ]) ?>

</div>
