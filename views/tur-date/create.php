<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TurDate */

$this->title = 'Добавить дату тура';
$this->params['breadcrumbs'][] = ['label' => 'Даты туров', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tur-date-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'etaps' => $etaps,
        'fields' => $fields,
    ]) ?>

</div>
