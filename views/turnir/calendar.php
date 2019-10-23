<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

?>
<div class="turnir-calendar">
<?= $model->showTitle();?>

    <div class="row filter">
    <?php $form = ActiveForm::begin(); ?>
        <p>Показать матчи турнира по фильтру:</p>   
        <div class="col-xs-4 col-sm-4 col-md-4">
            <?= $form->field($game, 'tur')
                ->dropDownList(
                    ArrayHelper::map($model->turs, 'tur', 'tur') ,
                    ['prompt'=>'Все туры'])
                    ->label(false); 
            ?>
        </div>
        <div class="col-xs-4 col-sm-4 col-md-4">
            <?= $form->field($game, 'team1_id')
                ->dropDownList(
                    ArrayHelper::map($model->teams, 'id', 'name') ,
                    ['prompt'=>'Все команды'])->label(false); 
            ?>
        </div>
    <?php ActiveForm::end(); ?>
    </div>

    <div class="games-result">    
    <?php foreach($model->stages as $stage): ?>
        
        <?php foreach($stage->etaps as $etap): ?>
            <p class="stage-name"><?=$etap->name;?></p>
            
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
                
                <?php foreach($etap->games as $game): ?>
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
                    <td class="tc-date"><?=$game->dateFormat;?></td>
                    <td class="tc-time"><?=$game->timeFormat;?></td>
                    <td class="tc-team1"><?=$game->team1->link;?></td>
                    <td class="tc-goals"><?=$game->gol1;?> - <?=$game->gol2;?></td>
                    <td class="tc-team2"><?=$game->team2->link;?></td>
                    <td>
                        <?= Html::a('<span class="glyphicon glyphicon-eye-open"></span> обзор', ['/game/'.$game->id]) ?>
                        &nbsp;&nbsp;&nbsp; 
                        <? If (Yii::$app->user->can('admin')) : ?>
                        <span class="glyphicon glyphicon-list-alt <?= $game->protocol ? "proto_yes" : "proto_no"; ?>" data-game="<?=$game->id;?>"></span>
                        <? endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            
            </table>
            
        <?php endforeach; ?>
    <?php endforeach; ?>
    </div>
</div>

<? $this->registerJs('
    $("select[id^=game-t]").change(function() {
        var tur = $("#game-tur").val();
        var team = $("#game-team1_id").val();
        
        $.post("/turnir/find/'.$model->id.'", {"tur" : tur, "team" : team} , function(data) {
            $(".games-result").html(data);
        });
    
    });
    
    $(".glyphicon-list-alt").click(function() {
        var game = $(this).data("game");
        if ($(this).hasClass("proto_no")) {
            $(this).removeClass("proto_no");
            $(this).addClass("proto_yes");
        } else {
            $(this).removeClass("proto_yes");
            $(this).addClass("proto_no");
        }
        $.post("/game/protocol-set/"+game);
    });
');
?>
