<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\TurnirEtapType;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Turnir Etaps';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="turnir-etap-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'turnir_id',
            'name',
            [
                'attribute' => 'type',
                'format' => 'html',
                'value' => function ($model) {
                    return TurnirEtapType::findOne($model->type)->name;
                }
            ],
            'stage_id',
            'size',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
