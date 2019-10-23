<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DiaryCat */

$this->title = 'Дневник: Редактировать категорию' . ' ' . $model->name;
?>
<div class="diary-cat-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
