<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Diary */

$this->title = 'Дневник: редактировать выпуск' . ' "' . $model->name.'"';
$this->params['breadcrumbs'][] = ['label' => 'Diaries', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="diary-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'diary_cat' => $diary_cat,
    ]) ?>

</div>
