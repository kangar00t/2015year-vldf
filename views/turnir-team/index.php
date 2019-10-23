<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Turnir;
use app\models\Team;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Turnir Teams';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="turnir-team-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Turnir Team', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'turnir_id',
                'format' => 'html',
                'value' => function ($model) {
                    return Turnir::findOne($model->turnir_id)->link;
                }
            ],
            [
                'attribute' => 'team_id',
                'format' => 'html',
                'value' => function ($model) {
                    return Team::findOne($model->team_id)->link;
                }
            ],
            'status',
            'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
