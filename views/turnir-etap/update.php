<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TurnirEtap */

$this->title = 'Update Turnir Etap: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Turnir Etaps', 'url' => ['index', 'id' => $turnir->id]];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="turnir-etap-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'turnir' => $turnir,
        'types' => $types,
    ]) ?>

</div>
