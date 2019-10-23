<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Game */

$this->title = 'Обзор матча';
?>
<div class="game-view">
        
        <div class="row">
            <div class="col-xs-2 col-sm-2 col-md-2">
                <?= $model->team1->logoImg(100);?>
            </div>
            <div class="col-xs-4 col-sm-4 col-md-4 text-right">
                <?= $model->team1->sizelink(24);?>
                <p style="font-size: 20px;"><?= $model->gol1;?></p>
                <?= $model->pen1 ? '<p>'.$model->pen1.'</p>' : '';?>
            </div>
            
            <div class="col-xs-4 col-sm-4 col-md-4 text-left">
                <?= $model->team2->sizelink(24);?>
                <p style="font-size: 20px;"><?= $model->gol2;?></p>
                <?= $model->pen2 ? '<p>'.$model->pen2.'  ( пен. )</p>' : '';?>
            </div>
            <div class="col-xs-2 col-sm-2 col-md-2">
                <?= $model->team2->logoImg(100);?>
            </div>
        </div>
    
    <div class="row g-infi">
            
                <div class="col-xs-3 col-sm-3 col-md-3">
                    <p>Турнир:</p>
                    <p><?= $model->turnir->link;?></p>
                    <p><span> <?= $model->tur;?> тур</span></p>
                </div>
                <div class="col-xs-3 col-sm-3 col-md-3">
                    <p>Поле:<span> <?= $model->field->link;?></span></p>
                    <p>Дата:<span> <?= $model->dateFormatY;?></span></p>
                    <p>Время:<span> <?= $model->timeFormat;?></span></p>
                </div>
                <div class="col-xs-3 col-sm-3 col-md-3">
                    <p>Судейская бригада:</p>
                    <p><?= $model->ref1->link;?></p>
                    <p><?= $model->ref2->link;?></p>
                </div>
                <div class="col-xs-3 col-sm-3 col-md-3">
                <p>Действия:</p>
                <? If (Yii::$app->user->id AND (Yii::$app->user->can('admin') OR (Yii::$app->user->identity->profileModel->isRefGame($model->id)))) : ?>
                    <p>
                        <?= Html::a('Редактировать матч', ['update', 'id' => $model->id], ['class' => 'btn-primary']) ?>
                    </p>
                <? endif; ?>
                    <p>
                        <?= Html::a('Печать протокола', ['protocol-game', 'id' => $model->id], ['class' => 'btn-primary']) ?>
                    </p>
                </div>
                
                
                
                
                

        </div>   
            
        <? if (count($model->stat)) : ?>
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="h-block" style="height:20px; width: 280px;">
                    Игрок
                </div>
                <div class="h-block" style="height:20px; width: 45px;">
                    Голы
                </div>
                <div class="h-block" style="height:20px; width: 80px;">
                    Карточки
                </div>
                
                <? foreach ($model->stat as $stat) : ?>
                    <? if ($stat->team_id == $model->team1_id) : ?>

                    <div class="h-block" style="height:20px; width: 280px;">
                        <?=$stat->profile->link;?>
                    </div>
                    <div class="h-block" style="height:20px; width: 45px;">
                        <?= $stat->goals; ?>
                    </div>
                    <div class="h-block" style="height:20px; width: 80px;">
                        <?= $stat->cardsImg; ?>
                    </div>
                    <? endif; ?>
                <? endforeach; ?>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="h-block" style="height:20px; width: 280px;">
                    Игрок
                </div>
                <div class="h-block" style="height:20px; width: 45px;">
                    Голы
                </div>
                <div class="h-block" style="height:20px; width: 80px;">
                    Карточки
                </div>
                
                <? foreach ($model->stat as $stat) : ?>
                    <? if ($stat->team_id == $model->team2_id) : ?>

                    <div class="h-block" style="height:20px; width: 280px;">
                        <?=$stat->profile->link;?>
                    </div>
                    <div class="h-block" style="height:20px; width: 45px;">
                        <?= $stat->goals; ?>
                    </div>
                    <div class="h-block" style="height:20px; width: 80px;">
                        <?= $stat->cardsImg; ?>
                    </div>
                    <? endif; ?>
                <? endforeach; ?>
            </div>
        </div>
        <? endif; ?>
        
        <div class="row g-infi">
        <p>История игр команд:</p>
        <? if (count($model->oldGames)) : ?>
            <? foreach($model->oldGames as $game) : ?>
                <p><?= $game->team1->link; ?> <?= $game->gol1; ?>-<?= $game->gol2; ?> <?= $game->team2->link; ?> <?= $game->turnir->link; ?></p>
            <? endforeach; ?>
        <? endif; ?>
        </div>
         

</div>
