<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Diary */

$this->title = 'Дневник: добавить выпуск';
?>
<div class="diary-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'diary_cat' => $diary_cat,
    ]) ?>

</div>
