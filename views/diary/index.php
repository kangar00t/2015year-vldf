<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Дневник ВЛДФ';
?>
<div class="diary-index">

    <h1><?= Html::encode($this->title) ?></h1>

<? if (Yii::$app->user->can('diaryManager')) : ?>

    <p>
        <?= Html::a('Добавить выпуск', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <p>
        <?= Html::a('Категории', ['/diary-cat'], ['class' => 'btn btn-success']) ?>
    </p>

<? endif; ?>

    <? $dshow = ''; $first = 1;?>
    <div class="d-list">
        <? foreach ($dcats as $dcat) : ?>
            <ul>
                <span class="show-item <?= $first ? 'active':'';?>" data-cat="<?= $dcat->id;?>"><?= $dcat->name;?></span>
                <? foreach ($dcat->diaries as $diary) : ?>
                        <li <?= $first ? '' : 'style="display:none;"';?> class="dcat-<?=$dcat->id;?>">
                            <?= $diary->name; ?>
                            <? If (Yii::$app->user->can('diaryManager')) : ?>
                                <?= Html::a(' (ред.)', ['update', 'id' => $diary->id]) ?>
                            <? endif; ?>
                            <input type="hidden" value="<?= $diary->id;?>" />
                        </li>
                <? endforeach; ?>
                <? $first = 0;?>
            </ul>
        <? endforeach; ?>
    </div>
    <div class="d-view">
    </div>

</div>

<? $this->registerJs('

    var el = $(".d-list > ul > li:first");
    var id = el.find("input").val();
    el.addClass("show");
    
    $.post("/diary/find", {"diary" : id} , function(data) {   
        $(".d-view").html(data);
    });
        
    $(".d-list > ul > li").click(function() {
        var id = $(this).find("input").val();
        $(".show").removeClass("show");
        $(this).addClass("show");
        $.post("/diary/find", {"diary" : id} , function(data) {   
            $(".d-view").html(data);
        });
    });

    $(".show-item").click(function() {
        $(".d-list li").hide();
        let cat = $(this).data("cat");
        $(".show-item.active").removeClass("active");
        $(this).addClass("active");
        $(".dcat-"+cat).show()
    });
');
?>
