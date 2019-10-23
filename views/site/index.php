<?php

use yii\helpers\Html;
use app\models\Game;

$this->title = 'vldf';
?>
<div class="site-index">
<div class="row">
    <div class="col-xs-8 col-sm-8 col-md-8" style="font-size: 14px;    margin-top: 20px;">
    
        <? If (!Yii::$app->user->id) : ?> 
            <div class="alert alert-warning" role="alert">
                Играете в ВЛДФ? Есть своя команда? Или Вы судья на соревнованиях?<br />
                Идентифицируйте себя для получения новых возможностей!<br />
                <a href="/signup">Пройдите регистрацию</a> или <a href="/login">войдите на сайт</a>, используя Ваши учетные данные.         
            </div>
        <? endif; ?>
        
        <? if (Yii::$app->user->id && !Yii::$app->user->identity->profileModel->filled()) : ?>
            <div class="alert alert-warning" role="alert">
                Для прохождения идентификации на сайте необходимо заполнить <a href="/profile/<?= Yii::$app->user->identity->profile_id; ?>">Ваш профиль</a>.
                Пожалуйста, <a href="/profile/update/<?= Yii::$app->user->identity->profile_id; ?>">пройдите на страницу редактирования профиля</a>.
            </div>
        <? endif; ?>
        <?= $diary->link;?>
        <p><a href="/diary">Смотреть предыдущие выпуски</a></p>
        
        <div class="news_title news_status_<?= $news->status;?>">
            <?= $news->title; ?>        
            <p><?= $news->created_at; ?></p>
        </div>
        <div class="news_text">
            <div style="float: left;">
                <?if ($news->image) : ?>
                    <img src="/img/news/<?= $news->image;?>" width="250px" />
                <? endif; ?> 
            </div>
            <div>
                <?= $news->text; ?>
                 
            </div>              
                  
        </div>  
        <div class="news_bottom">
            <a href="/news/<?=$news->id; ?>">Перейти к новости</a> | <a href="/news">Новостная лента</a>  
        </div>
    </div>
    <div class="col-xs-4 col-sm-4 col-md-4">
    <br />
        <script type="text/javascript" src="//vk.com/js/api/openapi.js?116"></script>

        <!-- VK Widget -->
        <div id="vk_groups"></div>
        <script type="text/javascript">
        VK.Widgets.Group("vk_groups", {mode: 0, width: "300", height: "317", color1: 'FFFFFF', color2: '2B587A', color3: '5B7FA6'}, 2058590);
        </script>
        
        <!--<iframe src='/components/widgets/inwidget/index.php?width=300&inline=2&view=4&toolbar=false' scrolling='no' frameborder='no' style='border:none;width:400px;height:352px;overflow:hidden;margin: 20px 0;'>
        </iframe>-->
        
        
    </div>
    
</div>



    <div class="row" style="background: url(/img/fon_games2.jpg) no-repeat; height:653px;">
        <p style="    margin: 15px;
                font-size: 20px;
                font-weight: bold;
                color: rgb(236, 237, 163);
                border: 1px solid white;
                padding-left: 5px;
                text-shadow: 2px 2px 1px black;">
            Ближайшие и недавние игры
        </p>
        <div class="col-xs-2 col-sm-2 col-md-2" style="font-size: 14px;padding-top: 10px;">
        <? $i = 0; ?>
        <? foreach ($games as $game) : ?>
            <? $class = '';?>
            <? if (!$date AND !($game->date < date('Y-m-d'))) : ?>
                <? $date = $game->date; ?>
                <? $class = 'active';?>
            <? endif; ?>
            <? $i++; ?>
            <? if (!$date AND ($i == count($games))) : ?>
                <? $date = $game->date; ?>
                <? $class = 'active';?>
            <? endif; ?>
            
            <? 
                $mdate=explode("-", $game->date);
                $w = date("w", mktime(0, 0, 0, $mdate[1], $mdate[2], $mdate[0]));
                $week=array(0=>"вс", "пн","вт","ср","чт","пт","сб");
            ?>
            <p class="show_date_game <?=$class;?>" data-date="<?= $game->date; ?>" style="cursor: pointer;
                border: 1px solid #fff;
                color: #fff;
                padding: 5px;
                font-size: 14px;
                font-weight: 600;
                text-shadow: 2px 2px 1px black;
                box-shadow: 1px 1px 1px black;
                background-color: rgba(255,255,255,0.5);">
                    <?=$game->dateFormat;?> <span
                    <? if (($w == 6) OR ($w == 0)) echo 'style="color:#FF7777;"';?>
                    >[<?= $week[$w];?>]</span>
            </p>
        <? endforeach;?>
        </div>
        <div class="col-xs-10 col-sm-10 col-md-10" style="font-size: 14px;padding-top: 10px;">
            <div class="date-games" style="padding: 10px;
                    border: 1px solid #00308B;    
                    background-color: rgba(255,255,255,0.5);    
                    overflow-y: scroll;
                    max-height: 500px;">
                Загрузка...
            </div>
        </div>
        <!--<a href="/game">
            <p style="    border: 1px solid white;
                color: white;
                margin: 7px;
                width: 200px;
                font-size: 18px;
                padding: 3px;">
                
                Перейти в раздел игр
            </p>
        </a>-->
    </div>
    
<div class="row">
<hr />
<div class="col-xs-12 col-sm-12 col-md-12" style="font-size: 14px;">
<p style="margin-top: 10px;">Наши партнеры:</p>
      
      <a href="http://www.decathlon.ru/" target="_blank" style="  display: block;
      float: left;
      width: 120px;
      height: 90px;
      border: 1px solid #ccc;
      margin-right: 20px;
      padding: 28px 0 0 3px;
      background-color: white;"
      ><img src="/img/dekatlon.png" width="113px"/></a>

      <a href="http://new.vk.com/bar_pivasi" target="_blank" style="  display: block;
      float: left;
      width: 120px;
      height: 90px;
      border: 1px solid #ccc;
      margin-right: 20px;
      padding: 0px 0 0 14px;
      background-color: white;"
      ><img src="/img/pivo.jpg" height="88px"/></a>

      <a href="https://vk.com/magazin_turnir" target="_blank" style="  display: block;
      float: left;
      width: 120px;
      height: 90px;
      border: 1px solid #ccc;
      margin-right: 20px;
      padding: 0px 0 0 14px;
      background-color: white;"
      ><img src="/img/turnir.jpg" height="88px"/></a>

      <a href="https://vk.com/realestatevrn" target="_blank" style="  display: block;
      float: left;
      width: 120px;
      height: 90px;
      border: 1px solid #ccc;
      margin-right: 20px;
      padding: 0px 0 0 15px;
      background-color: white;"
      ><img src="/img/tsun.png" width="88px"/></a>
      
      <a href="http://www.o-vode.ru/" target="_blank" style="  display: block;
      float: left;
      width: 90px;
      height: 90px;
      margin-right: 20px;
      margin-top: 0px;
      background-color: white;"><img src="/img/vi.jpg" width="90px"/></a>
      
</div>
</div>
</div>

<? $this->registerJs('
    var date = $(".active").data("date");
    $.post("/game/date-games", {"date" : date} , function(data) {    
        if (data) $(".date-games").html(data);
        else $(".date-games").html("Нет игр для отображения");
    });

    $(".show_date_game").click(function() {
        var date = $(this).data("date");
        $(".active").removeClass("active");
        $(this).addClass("active");
        $.post("/game/date-games", {"date" : date} , function(data) {   
            $(".date-games").html(data);
        });
        
    });
');
?>
