<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\TurnirEtapType;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="turnir-etap-index">

    <?= $turnir->showTitle();?>
    <p>
        <?= Html::a('Create Turnir Etap', ['create', 'id' => $turnir->id], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            [
                'attribute' => 'type',
                'format' => 'html',
                'value' => function ($model) {
                    return TurnirEtapType::findOne($model->type)->name;
                }
            ],
            'stage_id',
            'steps',
            'size',
            'sort',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
