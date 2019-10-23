<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Игроки';
?>
<div class="profile-index">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <? if (Yii::$app->user->can('admin')) : ?>
    <?= Html::a('Создать профиль', ['create'], ['class' => 'btn btn-success']) ?>
    <? endif; ?>
    
    <div class="row">
        <p>Поиск игрока</p>
        <div class="col-xs-4 col-sm-4 col-md-4 text-right">
            <p>
                <?= Html::label('Фамилия', 'lname') ?>
                <?= Html::input('text', 'lname', $user, ['class' => 'lname add-player']) ?>
            </p>
            <p>
                <?= Html::label('Имя', 'fname') ?>
                <?= Html::input('text', 'fname', $user, ['class' => 'fname add-player']) ?>
            </p>
            <p><?= Html::Button('Поиск', ['class' => 'btn btn-success']) ?></p>
        </div>
        <div class="col-xs-8 col-sm-8 col-md-8 search-result">
        </div>
        
    </div>

</div>

<? $this->registerJs('
$(".add-player").focusout(function () {
    
    var lname = $(".lname").val();
    var fname = $(".fname").val();
    
    $.post("/profile/find", {"lname" : lname, "fname" : fname} , function(data) {
        $(".search-result").html(data);
    });
  
});

');
?>