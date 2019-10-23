<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TurTime */

$this->title = 'Create Tur Time';
$this->params['breadcrumbs'][] = ['label' => 'Tur Times', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tur-time-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
