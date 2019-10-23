<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TurnirEtapType */

$this->title = 'Create Turnir Etap Type';
$this->params['breadcrumbs'][] = ['label' => 'Turnir Etap Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="turnir-etap-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
