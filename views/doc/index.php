<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Документы';
?>
<div class="doc-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <? if (Yii::$app->user->can('admin')) : ?>
    <p>
        <?= Html::a('Добавить документ', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
	<? endif; ?>

    <? foreach ($docs as $doc) : ?>
        
        

        <div class="doc-item">
            <p class="d-name">
                <? if (Yii::$app->user->can('admin')) : ?>
                    <?= Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['/doc/update/'.$doc->id]) ?>
                <? endif; ?>

            	<a href="/web/docs/<?=$doc->name;?>">Скачать</a> <?=$doc->text;?>
            </p> 
        </div>
        
    <? endforeach; ?>

</div>
