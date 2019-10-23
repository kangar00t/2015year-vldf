<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Team */

$this->title = $model->name;

?>
<div class="team-view">
    <div class="row">
        <div class="col-md-3">
            <?= $model->LogoImg(200); ?>
        </div>
        <div class="col-md-9">
            <h1><?= Html::encode($this->title) ?></h1>
            <?= Yii::$app->user->can('admin') ?
            '<p>'.Html::a("Редактировать", ["update", "id" => $model->id], ["class" => "btn btn-primary"]).'</p>' : false;  
            ?>
            <? if ($model->creator != 44) : ?>
                Управление командой:
                <p><?= $model->creatorModel->fullLink;?></p>
            <? endif; ?>
        </div>
    </div>

    <div class="row g-infi">
        <div class="col-md-4">
            
            
            Участие в турнирах:
            <? foreach ($model->turnirTeamsOne as $tteam) : ?>
                    <p class="tturnir-btn"><?= $tteam->turnir->link; ?> <a class="show_list" data-tteam="<?= $tteam->id; ?>">состав >></a></p>
            <? endforeach; ?>
            
        </div>
        
        <div class="col-md-8">
            <div class="tlist-block">
                Игроки команды:
                <? foreach ($model->teamLists as $tlist) : ?>
                            <div class="profile-card" style="margin: 5px; height: 75px;">
                                <?= $tlist->profile->avatar(60); ?> 
                                <div class="info">
                                    <div class="p-name"><?= $tlist->profile->fullLink; ?></div>
                                    <div style="float: left;">
                                    Всего игр за команду:
                                    <div class="progress" style="width: 170px;">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?= $tlist->StatGameTeamPersent();?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $tlist->StatGameTeamPersent();?>%">
                                            <?= count($tlist->statGameTeam()); ?>
                                        </div>
                                    </div>
                                    </div>
                                    <div style="float: left;">
                                    Всего игр за команду:
                                    <div class="progress" style="width: 170px;">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?= $tlist->sumGoalsPersent();?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $tlist->sumGoalsPersent();?>%">
                                            <?= $tlist->sumGoals(); ?>
                                        </div>
                                    </div>
                                    </div>
                                    
                                </div>
                                
                            </div>
                <? endforeach; ?>
            
            </div>
        </div>
    </div>
</div>

<? $this->registerJs('
    var date = $(".active").data("date");

    $(".show_list").click(function() {
        $(".tlist-block").html("Идет загрузка состава. Пожалуйста, подождите.");
        var tteam = $(this).data("tteam");
        $(".active").removeClass("active");
        $(this).addClass("active");
        $.post("/team-list/tteam-list", {"tteam_id" : tteam} , function(data) {   
            $(".tlist-block").html(data);
        });
        
    });
');
?>