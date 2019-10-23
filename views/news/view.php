<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\News */

$this->title = $model->title;
?>
<div class="news-view">

        <div class="news_title">
            <?= $model->title; ?>
            
            <? if (Yii::$app->user->can('admin')) : ?>
            <div class="edit_btn">
                <a href="/news/<?=$model->id; ?>" class="btn-xs btn-default glyphicon glyphicon-eye-open"></a>
                <a href="/news/update/<?=$model->id; ?>" class="btn-xs btn-default glyphicon glyphicon-edit"></a>
                <?= Html::a('', ['delete', 'id' => $model->id], [
                    'class' => 'btn-xs btn-danger glyphicon glyphicon-remove',
                    'data' => [
                        'confirm' => 'Новость будет удалена безвозвратно. Вы уверены?',
                        'method' => 'post',
                    ],
                ]) ?>
            </div>      
            <? endif; ?>   
            
            <p><?= $model->created_at; ?></p>
        </div>
        
        <div class="news_text">
            <?if ($model->image) : ?>
                <img src="/img/news/<?= $model->image;?>" width="250px" />
        <? endif; ?>                
            <?= $model->text; ?>            
        </div>   
</div>
