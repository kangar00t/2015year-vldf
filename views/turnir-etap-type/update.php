<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TurnirEtapType */

$this->title = 'Update Turnir Etap Type: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Turnir Etap Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="turnir-etap-type-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
