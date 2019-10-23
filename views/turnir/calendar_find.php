<?
    use yii\helpers\Html;
?>        
        
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
            
            <?php foreach($games as $game): ?>
            <tr
                <? if ($game->statusStat) : ?>
                    style="background-color: #b6ffb2;"
                <? elseif ($game->bedStat) : ?>
                    style="background-color: #ffb2b2;"
                <? endif; ?>
            >
                <td class="tc-tur">
                    <?=$game->tur;?>
                </td>
                <td class="tc-tur"><?=$game->field->name;?></td>
                <td class="tc-date"><?=$game->date;?></td>
                <td class="tc-time"><?=$game->time;?></td>
                <td class="tc-team1"><?=$game->team1->link;?></td>
                <td class="tc-goals"><?=$game->gol1;?> - <?=$game->gol2;?></td>
                <td class="tc-team2"><?=$game->team2->link;?></td>
                <td><?= Html::a('<span class="glyphicon glyphicon-eye-open"></span> обзор', ['/game/'.$game->id]) ?></td>
            </tr>
            <?php endforeach; ?>
        
        </table>