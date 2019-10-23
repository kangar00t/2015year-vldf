<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TurnirTeam */

$this->title = 'Create Turnir Team';
$this->params['breadcrumbs'][] = ['label' => 'Turnir Teams', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="turnir-team-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'teams' => $teams,
        'turnirs' => $turnirs,
    ]) ?>

</div>
