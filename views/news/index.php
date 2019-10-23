<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Новости';
?>
<div class="news-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <? if (Yii::$app->user->can('admin')) : ?>
        <p>
            <?= Html::a('Добавить новость', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <? endif; ?>
    <? foreach ($news_all as $news) : ?>
        <hr />
        <div class="news_title news_status_<?= $news->status;?>">
            <?= $news->title; ?>        
            <? if ($news->status ==2) : ?>
            <div class="edit_btn">
            <span>прикреплена</span>
            </div>
            <? endif; ?>
            <p><?= $news->created_at; ?></p>
        </div>
        
        <div class="news_text">
            <div style="float: left;">
                <?if ($news->image) : ?>
                    <img src="/img/news/<?= $news->image;?>" width="250px" />
                <? endif; ?> 
            </div>
            <div style="float: left; width: 70%;">
                <?= $news->textShot; ?>   
                <br />
                <a href="/news/<?=$news->id; ?>">Перейти к новости</a>   
            </div>              
                  
        </div>                
                        
    <? endforeach; ?>        


</div>
