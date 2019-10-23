<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Команды';
?>
<div class="profile-index">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <? if (!Yii::$app->user->isGuest) : ?>
        <?= Html::a('Создать команду', ['create'], ['class' => 'btn btn-success']) ?>
    <? endif; ?>
    
    <div class="row">
        <p>Поиск команды</p>
        <div class="col-xs-4 col-sm-4 col-md-4 text-right">
            <p>
                <?= Html::label('Название', 'team-name') ?>
                <?= Html::input('text', 'team-name', $team, ['class' => 'lname add-team']) ?>
            </p>
            <p><?= Html::Button('Поиск', ['class' => 'btn btn-success']) ?></p>
        </div>
        <div class="col-xs-8 col-sm-8 col-md-8 search-result">
        </div>
        
    </div>

</div>

<? $this->registerJs('
$(".add-team").focusout(function () {
    
    var name = $(".add-team").val();
    
    $.post("/team/find", {"name" : name} , function(data) {
        $(".search-result").html(data);
    });
  
});

');
?>