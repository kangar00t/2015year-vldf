<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Doc */

$this->title = 'Добавить документ';
?>
<div class="doc-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
