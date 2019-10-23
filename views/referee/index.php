<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Судьи';
?>
<div class="referee-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p class="top-btn">
        <?= Html::a('Добавить в коллегию', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Расставить судей', ['admin'], ['class' => 'btn btn-success']) ?>
    </p>

    <? foreach ($referees as $referee) : ?>
        <p>
        	<span class="c1"><?= $referee->profile->refGames; ?></span>
        	<span class="c2"><?= $referee->profile->link; ?></span>
        	<span class="c3"><?= Html::a('(матчи)', ['/referee/'.$referee->id]) ?></span>
        </p>
    <? endforeach; ?>

</div>
