<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TurnirEtap */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Turnir Etaps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="turnir-etap-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'turnir_id',
            'stage_id',
            'steps',
            'type',
            'name',
            'size',
        ],
    ]) ?>

</div>
