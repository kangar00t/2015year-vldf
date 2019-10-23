<?php

use yii\helpers\Html;

?>

<div class="turnir-table">
    <p><?= $etap->name; ?></p>
    
    <table class="table table-striped">
        <tr>
            <th class="tt-name2">Команда</th>
            <th class="tt-int2">Счет</th>
            <th class="tt-name2">Команда</th>
            <th><span class="glyphicon glyphicon-eye-open"></span></th>
        </tr>

        <? foreach ($games as $game) : ?>
            <? if ($game->team1_id == $team_id) : ?>
                <? if ($game->gol1 > $game->gol2) : ?>
                    <? $color = 'green'; ?>
                <? elseif ($game->gol1 < $game->gol2) : ?>
                    <? $color = 'red'; ?>
                <? else : ?>
                    <? $color = 'gray'; ?>
                <? endif; ?>
                <tr>
                    <td><?=$game->team1->link;?></td>
                    <td><span style="color: <?= $color; ?>;"><?=$game->gol1;?> - <?=$game->gol2;?></span></td>
                    <td><?=$game->team2->linkImg;?></td>
                    <td><?= Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['/game/'.$game->id]) ?></td>
                </tr>
            <? elseif ($game->team2_id == $team_id) : ?>
                <? if ($game->gol2 > $game->gol1) : ?>
                    <? $color = 'green'; ?>
                <? elseif ($game->gol2 < $game->gol1) : ?>
                    <? $color = 'red'; ?>
                <? else : ?>
                    <? $color = 'gray'; ?>
                <? endif; ?>
                <tr>
                    <td><?=$game->team2->link;?></td>
                    <td><span style="color: <?= $color; ?>;"><?=$game->gol2;?> - <?=$game->gol1;?></span></td>
                    <td><?=$game->team1->linkImg;?></td>
                    <td><?= Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['/game/'.$game->id]) ?></td>
                </tr>
            <? else : ?>
                <tr>
                    <td colspan="4"><?=$team->linkImg;?> (просмотр игр команды)</td>
                </tr>
            <? endif; ?>                     
        <?php endforeach; ?>
    </table>
</div>