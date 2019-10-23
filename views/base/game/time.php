<?
use yii\helpers\Html;
?>

<h3>Выбор времени</h3>

<div class="row">
    <? if (count($turdates)) : ?>
        Следующие матчи доступны для выбора времени:
        <? Foreach ($turdates as $turdate) : ?>
            <? Foreach ($turdate->games as $game) : ?>
                 <? If (($game->team1->creator == Yii::$app->user->identity->profile_id) OR ($game->team2->creator == Yii::$app->user->identity->profile_id)) : ?>
                    <p>
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