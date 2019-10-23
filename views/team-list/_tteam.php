<?php
    use yii\helpers\Html;
?>

<h2>Текущий состав на турнир<br><?=$tteam->turnir->link;?></h2>
<? if ($tteam->team->isYour AND ($tteam->turnir_id <> 813)) : ?>
    <p><?= Html::a('РЕДАКТИРОВАТЬ СОСТАВ', ['/team-list/turnir/'.$tteam->id], ['class' => 'look-on-link']) ?></p>
<? endif; ?>

<? foreach($tteam->teamList as $tlist) : ?>
    <? if ($tlist->date_out > $tteam->turnir->ended_at) : ?>
        <? if ($tlist->profile) : ?>
        <div class="profile-card" style="margin: 5px; height: 75px;">
            <?= $tlist->profile->avatar(60); ?> 
            <div class="info">
                <div class="p-name">
                    <?= $tlist->profile->fullLink; ?>
                    <? if ($tlist->date_in > $tteam->turnir->started_at) : ?>
                        <a class="arrow-add" data-toggle="tooltip" title="Дозаявлен <?= $tlist->date_in;?>"></a>
                    <? endif; ?>
                    <? if ($tlist->date_out < $tteam->turnir->ended_at) : ?>
                        <a class="arrow-remove" data-toggle="tooltip" title="Отзаявлен <?= $tlist->date_out;?>"></a>
                    <? endif; ?>
                </div>
                
                <p>
                    Игр в турнире: 
                    <?= count($tlist->statGameAll()); ?>
                </p>
            </div>
        </div>
        <? else : ?>
        <p>
            <?= $tlist->id; ?>
        </p>
        <? endif; ?>    
    <? endif; ?>
<? endforeach; ?>

<h2>Отзаявленные игроки:</h2>
<? foreach($tteam->teamList as $tlist) : ?>
    <? if (($tlist->date_out < $tteam->turnir->ended_at) AND ($tlist->profile)) : ?>
        <div class="profile-card" style="margin: 5px; height: 75px;">
            <?= $tlist->profile->avatar(60); ?> 
            <div class="info">
                <div class="p-name">
                    <?= $tlist->profile->fullLink; ?>
                    <? if ($tlist->date_in > $tteam->turnir->started_at) : ?>
                        <a class="arrow-add" data-toggle="tooltip" title="Дозаявлен <?= $tlist->date_in;?>"></a>
                    <? endif; ?>
                    <? if ($tlist->date_out < $tteam->turnir->ended_at) : ?>
                        <a class="arrow-remove" data-toggle="tooltip" title="Отзаявлен <?= $tlist->date_out;?>"></a>
                    <? endif; ?>
                </div>
                
                <p>
                    Игр в турнире: 
                    <?= count($tlist->statGameAll()); ?>
                </p>
            </div>
            
        </div>
    <? endif; ?>
<? endforeach; ?>