<?php
use yii\helpers\Html;
?>

<? foreach ($tlists as $tlist) : ?>
    <p>
        <?= Html::submitButton($tlist->profile->status ? 'скан' : 'скан', ['name' => $tlist->profile_id, 'class' => $tlist->profile->status ? 'scan-status btn btn-success' : 'scan-status btn btn-default']) ?>
        <?= $tlist->profile->fullLink; ?>
        <?= $tlist->team->link; ?>
    </p>
<? endforeach; ?>

<? $this->registerJs('

$(".scan-status").click(function () {
    
    
    var isscan = $(this).hasClass("btn-success");
    var p_id = $(this).attr("name");
    
    if (isscan) {
        $(this).removeClass("btn-success");
        $(this).addClass("btn-default");
    } else {
        $(this).addClass("btn-success");
        $(this).removeClass("btn-default");
    }
    
    $.post("/profile/scan", {"isscan" : isscan, "p_id" : p_id} , function(data) {
        //alert(data);
    });
  
});


');
?>