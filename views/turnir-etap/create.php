<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TurnirEtap */

$this->title = 'Создать группу/плэй-офф';
$this->params['breadcrumbs'][] = ['label' => 'Группы/Плэй-офф', 'url' => ['index', 'id' => $turnir->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="turnir-etap-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'turnir' => $turnir,
        'types' => $types,
    ]) ?>

</div>
