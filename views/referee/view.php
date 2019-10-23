<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Referee */

$this->title = $model->profile->fullName;
?>
<div class="referee-view">
    
    <h1>"Судейская". <?= Html::encode($this->title) ?></h1>
    <table class="table">
    <? foreach ($model->games as $game) : ?>
        <tr
            <? if ($game->statusStat) : ?>
                style="background-color: #b6ffb2;"
            <? elseif ($game->noStat) : ?>
                style="background-color: #ffb2b2;"                         
            <? elseif ($game->bedStat) : ?>
                style="background-color: #ffffb2;"
            <? endif; ?>
        >
            <td class="tc-tur">
                <?=$game->tur;?>
            </td>
            <td class="tc-tur"><?=$game->field->name;?></td>
            <td class="tc-date"><?=$game->date;?></td>
            <td class="tc-time"><?=$game->turnir->link;?></td>
            <td class="tc-team1"><?=$game->team1->link;?></td>
            <td class="tc-goals"><?=$game->gol1;?> - <?=$game->gol2;?></td>
            <td class="tc-team2"><?=$game->team2->link;?></td>
            <td><?= Html::a('<span class="glyphicon glyphicon-eye-open"></span> обзор', ['/game/'.$game->id]) ?></td>
        </tr>
    <?php endforeach; ?>
    </table>



</div>
