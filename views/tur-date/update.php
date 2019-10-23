<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TurDate */

$this->title = 'Рудактировать дату тура: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Даты туров', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="tur-date-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
