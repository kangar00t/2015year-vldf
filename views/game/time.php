<?
use yii\helpers\Html;
?>

<h3>Выбор времени</h3>

<? if (Yii::$app->user->can("admin")) : ?>
    <div class="row">
        Доступность выбора времени (<?=$choosetime->value;?>):
        <button class="btn btn-success setchoosetime<?=$choosetime->value ? ' active':'';?>" data-choose="1">Доступен</button>
        <button class="btn btn-success setchoosetime<?=$choosetime->value ? '':' active';?>" data-choose="0">Закрыт</button>
    </div>
<? endif;?>

<div class="row">
    <? if (count($turdates)) : ?>
        Следующие матчи доступны для выбора времени:
        <? Foreach ($turdates as $turdate) : ?>
            <? Foreach ($turdate->games as $game) : ?>
                 <? If (($game->team1->creator == Yii::$app->user->identity->profile_id) OR ($game->team2->creator == Yii::$app->user->identity->profile_id)) : ?>
                    <p>
                        <?= $game->tur; ?> тур (<?= $turdate->date; ?>) 
                        <?= $game->team1->link ?> - <?= $game->team2->link ?>
                        <?= Html::a('сделать выбор', ['/game/time/', 'id' => $game->id], ['class' => 'profile-link']) ?>
                    </p>   
                <? endif ?>
            <? endforeach; ?>
        <? endforeach; ?>
    <? else : ?>
        Нет матчей для выбора времени.
    <? endif ?>
</div>

<? $this->registerJs('
    
    $(".setchoosetime").click(function() {
        var btn = $(this);
        var choose = btn.data("choose");
        $.post(
            "/site/set-option",
            {"name":"choosetime", "value":choose},
            function(data) {
                $(".setchoosetime").removeClass("active");
                btn.addClass("active");
            }
        );
    });

');?>