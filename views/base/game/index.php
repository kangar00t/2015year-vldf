<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Игры';
?>
<div class="profile-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= Html::a('Выбор времени', ['/game/time'], ['class' => 'btn btn-success']); ?>
    <?If (Yii::$app->user->can('admin')) : ?> 
        <?= Html::a('Расписание', ['/game/time-admin'], ['class' => 'btn btn-success']); ?>
        <?= Html::a('Дата тура', ['/tur-date'], ['class' => 'btn btn-success']); ?>
        <?= Html::a('Время тура', ['/tur-time'], ['class' => 'btn btn-success']); ?>
    <? endif; ?>
    
    
    <? 
        $date = 0;
        $field = 0;   
    ?>
    <table>
    <? foreach ($games as $game) : ?>
    
    <? if (!($date == $game->date) OR ($field != $game->field_id)) : ?>
    <?
        $date = $game->date;
        $field = $game->field_id; 
    ?>
    </table>
    <h3><?=$game->field->name;?> <?=$game->dateFormat;?></h3>
    
    <table class="table">
        <tr>
            <th class="tc-tur">Тур</th>
            <th class="tc-field">Площадка</th>
            <th class="tc-date">Дата</th>
            <th class="tc-time">Время</th>
            <th class="tc-team1">Команда</th>
            <th class="tc-goals">Счет</th>
            <th class="tc-team2">Команда</th>
            <th></th>
        </tr>
    <? endif; ?>    
        
        <tr
                    <? if ($game->statusStat) : ?>
                        style="background-color: #b6ffb2;"
                    <? elseif ($game->noStat) : ?>
                        style="background-color: #ffb2b2;"                         
                    <? elseif ($game->bedStat) : ?>
                        style="background-color: #ffffb2;"
                    <? endif; ?>
                >
            <td class="tc-tur"><?=$game->tur;?></td>
            <td class="tc-tur"><?=$game->field->name;?></td>
            <td class="tc-date"><?=$game->dateFormat;?></td>
            <td class="tc-time"><?=$game->timeFormat;?></td>
            <td class="tc-team1"><?=$game->team1->link;?></td>
            <td class="tc-goals"><?=$game->gol1;?> - <?=$game->gol2;?></td>
            <td class="tc-team2"><?=$game->team2->link;?></td>
            <td><?= Html::a('<span class="glyphicon glyphicon-eye-open"></span> обзор', ['/game/'.$game->id]) ?></td>
        </tr>

    <? endforeach; ?>
    </table>
</div>