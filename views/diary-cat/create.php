<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\DiaryCat */

$this->title = 'Дневник: добавить категорию';
?>
<div class="diary-cat-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
