<?php
    use yii\helpers\Html;
?>

<h3>Заявка команды <?= $team->link; ?> на турнир <?= $turnir->link; ?></h3>
<p>Введите данные игрока и, если он уже зарегистрирован в системе, выберите его из списка справа:</p>



<div class="col-md-3">
    <div class="team-list-u">
    <p>Состав команды на турнир :</p>    
        <?php if (count($tteam->teamList)) : ?>
            <p><?= count($tteam->teamListNow);?> человек всего (<?=$tteam->teamListAddedCount;?>)</p>
            <?php foreach($tteam->teamList as $tlist) : ?>
                
                <? if ($tlist->date_out > $tlist->turnir->ended_at) : ?>
                
                <p class="profile-card" data-tl_id="<?=$tlist->id;?>" style="<?=Yii::$app->user->can("admin") ? 'height: 130px;':'height: 75px;';?>">
                    <img src="/img/avatars/<?= $tlist->profile->photo;?>.jpg" width="50px"/>
                    <?= $tlist->profile->link; ?>
                    <br />
                    <? If (!count($tlist->statGameAll()) OR true) : ?>
                        <?= Html::button('Удалить', ['class' => 'btn-sm btn-danger tlist-del']) ?>
                    <? else : ?>
                        <?= Html::button('Удалить', ['class' => 'btn-sm btn-default', 'disabled' => 'disabled']) ?>
                    <? endif; ?>
                    <? if (Yii::$app->user->can("admin")) : ?>
                        <br />
                        Дата заявки:<br />
                        <input type="text" class="date_in-<?=$tlist->id;?>" value="<?=$tlist->date_in;?>">
                        <?= Html::button('Изменить', ['class' => 'btn-sm btn-default tlist-date_in', 'data-id' => $tlist->id]) ?>
                        <span class="update-info-<?=$tlist->id;?>">
                    <? endif;?>
                </p>
                <? endif;?>
            <?php endforeach; ?>
            
        <?php else : ?>
            <p>В заявке нет игроков.</p>
        <?php endif; ?>
    </div>
</div>

<div class="col-md-4">
    <? If (count($tteam->teamListNow)<18) : ?>
    
    <?= $this->render('_form', [
        'profile' => $profile,
        'model' => $model,
        'turnir' => $turnir,
    ]) ?>
    
    <? else : ?>
        Вы не можете добавлять игроков. Лимит количества человек в заявке (18) достигнут.
    
    <? endif;?>

</div>
<div class="col-md-5">
    Игроки для добавления:
    <div class="search-result">
        
        <? foreach($tteam->team->teamListOld as $tlist) : ?>
            <div class="profile-card" style="margin: 5px; height: 75px;">
                <img src="/img/avatars/<?= $tlist->profileOld->photo;?>.jpg" width="60px"/>
                <div class="info">
                    <div class="p-name" style="margin-top: -5px;"><?= $tlist->profileOld->fullLink; ?> (<?= $tlist->profileOld->id; ?>)</div>
                    <?= Html::submitButton('Выбрать', [
                        'class' => 'btn btn-success add-team-list btn-sm', 
                        'name' => $tlist->profileOld->id, 
                        'onclick' => '
                            $("#teamlist-profile_id").val('.$tlist->profileOld->id.');
                            $("#profile-lname").val("'.$tlist->profileOld->lname.'");
                            $("#profile-fname").val("'.$tlist->profileOld->fname.'");
                            $("#profile-sname").val("'.$tlist->profileOld->sname.'");
                            $("#profile-birthday").val("'.$tlist->profileOld->birthday.'");
                        ',
                    ]) ?>
                </div>
                
            </div>
        <? endforeach; ?>
    </div>
</div>    


<? $this->registerJs('

$(".add-player").focusout(function () {
    
    var lname = $("#profile-lname").val();
    var fname = $("#profile-fname").val();
    
    $.post("/profile/search", {"lname" : lname, "fname" : fname} , function(data) {
        $(".search-result").html(data);
    });
  
});

$(".add-player-new").change(function () {
    
    if ($(this).prop("checked")) {
        $(".field-teamlist-profile_id").hide();
        $("#teamlist-profile_id").val("777");    
    }
    else {
        $(".field-teamlist-profile_id").show();
        $("#teamlist-profile_id").val("");
    }
});

$(".tlist-del").click(function () {
    var tl_id = $(this).parent().data("tl_id");
    var block = $(this).parent();
    $.post("/team-list/delete", {"tl_id" : tl_id} , function(data) {
        block.html(data);
    });
});

$(".tlist-date_in").click(function () {
    var tl_id = $(this).data("id");
    var date = $(".date_in-"+tl_id).val();
    $.post("/team-list/datein-update", {"tl_id" : tl_id, "date_in":date} , function(data) {
        $(".update-info-"+tl_id).html(data);
    });
});


');
?>