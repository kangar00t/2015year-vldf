<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TurTime */

$this->title = 'Update Tur Time: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tur Times', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tur-time-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
