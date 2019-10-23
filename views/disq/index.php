<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Дисквалификации';
?>
<div class="disq-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <? if (Yii::$app->user->can('admin')) : ?>
    <p>
        <?= Html::a('Добавить дисквалификацию', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <? endif; ?>

    <? foreach ($disqs as $disq) : ?>
        <div class="disq-item">
            <p class="d-date">
                <? if (Yii::$app->user->can('admin')) : ?>
                    <?= Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['/disq/update/'.$disq->id]) ?>
                <? endif; ?>
            </p> 
            <p class="d-prof"><?= $disq->profile->link;?></p>
            <p class="d-text"><?= $disq->text;?></p>
            <p class="d-stat"></p>
        </div>
    <? endforeach; ?>

</div>
