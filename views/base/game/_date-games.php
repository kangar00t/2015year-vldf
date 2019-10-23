<? 
    use yii\helpers\Html;
    $field = 0;   
?>

<table>
    <? foreach ($games as $game) : ?>

        <? if ($field != $game->field_id) : ?>
            <?
                $field = $game->field_id; 
            ?>
</table>
            <h4><?=$game->field->name;?></h4>

<table class="table">
    <tr>
        <th class="tc-time">Время</th>
        <th class="tc-team1">Команда</th>
        <th class="tc-goals">Счет</th>
        <th class="tc-team2">Команда</th>
        <th></th>
    </tr>
<? endif; ?>    
    
    <tr>
        <td class="tc-time"><?=$game->timeFormat;?></td>
        <td class="tc-team1"><?=$game->team1->linkImg;?></td>
        <td class="tc-goals"><?=$game->gol1;?> - <?=$game->gol2;?></td>
        <td class="tc-team2"><?=$game->team2->linkImg;?></td>
        <td><?= Html::a('<span class="glyphicon glyphicon-eye-open"></span> обзор', ['/game/'.$game->id]) ?></td>
    </tr>

<? endforeach; ?>
</table>