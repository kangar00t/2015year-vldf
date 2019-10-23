<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Team Lists';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="team-list-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Team List', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'profile_id',
            'tteam_id',
            'turnir_id',
            'team_id',
            // 'date_in',
            // 'date_out',
            // 'type',
            // 'player',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
