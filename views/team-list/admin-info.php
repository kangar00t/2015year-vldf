<?php
    use yii\helpers\Html;
?>

<? foreach ($turnirs as $turnir) : ?>
    <h2><?= $turnir->name; ?></h2>
    <table class="table table-bordered">
        <th>Команда</th>
        <th>Дозаявки</th>
        <th>Без документов</th>
        <th>Действия</th>
    <? foreach ($turnir->turnirTeamsOne as $tteam) : ?>
        <tr
        <? if($tteam->test) : ?>
            style="background-color: greenyellow;"
        <? endif; ?>
        >
            <td><?= $tteam->team->link; ?></td>
            <td><?= count($tteam->teamListAdded); ?></td>
            <td><?= count($tteam->teamListNoDoc); ?></td>
            <td><?= Html::a('Редактировать', ['/team-list/admin', 'id' => $tteam->id], ['class' => 'btn']) ?></td>
        </tr>
    <? endforeach; ?>
    </table>
<? endforeach; ?>