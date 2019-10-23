<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset2;
use app\components\widgets\Alert;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset2::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<!-- Цикл по играм -->
<div id="protokol_one" style=" top: 0px;
  bottom: 0px;
  left: 0px;
  position: absolute;">
<? foreach ($games as $game) : ?>
            <table width=100% height=1075px>
                <tr>
                    <td>
                        <img src="/img/protokol_shapka.jpg" /><br/>
                        <table width=100%>
                            <tr>
                                <td width=60%>
                                    <table width=100%>
                                        <tr height=30px>
                                            <td width=43% align=right>
                                                <?= $game->team1->link; ?>
                                            </td>
                                            <td width=19% align=center>
                                            -<hr>
                                            </td>
                                            <td width=43%>
                                                <?= $game->team2->link; ?>
                                            </td>
                                        </tr>
                                        <tr height=30px>
                                            <td width=43% align=right>
                                                Счет первого тайма:
                                            </td>
                                            <td width=19% align=center>
                                            -<hr>
                                            </td>
                                            <td width=43%>
                                                
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td>
                                    <?= $game->turnir->link;?> ( <?= $game->tur;?>-й тур)<br/>
                                    Дата: <?= $game->date;?> <br/>Время: <?= $game->time;?> <br/>Место проведения: <?= $game->field->name;?>
                                </td>
                            </tr>
                        </table>
                        
                    </td>
                </tr>
                <tr>
                    <td>
                        <br/>
                        <table width=100% border=0px>
                            <tr>
                                <td width=50%>
                                    <?= $game->team1->link; ?> (всего ___ игроков на матч)<br> 
                                    <table width=100% border=1px>
                                        <tr height=19px>
                                            <td>#</td>
                                            <td>Игрок</td>
                                            <td width=30px>+/-</td>
                                            <td width=30px>Голы</td>
                                            <td width=30px>Фолы</td>
                                        <tr>
                                        <? foreach ($game->team1list as $t1list) : ?>
                                            <? $k++; ?>
                                            <tr height=19px>
                                                <td><?= $k; ?></td>
                                                <td><?= $t1list->profile->link;?></td>
                                                <td width=30px></td>
                                                <td width=30px></td>
                                                <td width=30px></td>
                                            <tr>   
                                        <? endforeach; ?>
                                        <? while ($k<20) : ?>
                                            <? $k++; ?>
                                            <tr height=19px>
                                                <td></td>
                                                <td></td>
                                                <td width=30px></td>
                                                <td width=30px></td>
                                                <td width=30px></td>
                                            <tr> 
                                        <? endwhile; ?>
                                        <? $k=0; ?>
                                    </table>
                                </td>
                                <td width=50%>
                                    <?= $game->team2->link; ?> (всего ___ игроков на матч)<br>
                                    <table width=100% border=1px>
                                        <tr height=19px>
                                            <td>#</td>
                                            <td>Игрок</td>
                                            <td width=30px>+/-</td>
                                            <td width=30px>Голы</td>
                                            <td width=30px>Фолы</td>
                                        <tr>
                                        <? foreach ($game->team2list as $t2list) : ?>
                                            <? $k++; ?>
                                            <tr height=19px>
                                                <td><?= $k; ?></td>
                                                <td><?= $t2list->profile->link;?></td>
                                                <td width=30px></td>
                                                <td width=30px></td>
                                                <td width=30px></td>
                                            <tr>   
                                        <? endforeach; ?>
                                        <? while ($k<20) : ?>
                                            <? $k++; ?>
                                            <tr height=19px>
                                                <td></td>
                                                <td></td>
                                                <td width=30px></td>
                                                <td width=30px></td>
                                                <td width=30px></td>
                                            <tr> 
                                        <? endwhile; ?>
                                        <? $k=0; ?>
                                    </table>
                                </td>                                
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                    Предупреждения игрокам (ф.и.о.; команда; причина):
                    <hr><br/><hr><br/><hr><br/><hr><br/>
                    Замечания по проведению игры (порядок на стадионе; поведение команд, зрителей и т.п.):
                    <hr><br/><hr><br/><hr><br/><hr><br/>
                    Извещение о подаче протеста (краткое изложение существа протеста):
                    <hr><br/><hr><br/><hr><br/><hr><br/>
                    Представители команд:<br/>
                        <table width=100% border=0px>
                            <tr height=19px>
                                <td>
                                 <?= $game->team1->link; ?>
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                            </tr>
                            <tr height=19px>
                                <td width=35%>
                                    <hr>Команда
                                </td>
                                    
                                <td width=35%>
                                    <hr>Ф.И.О.
                                </td>
                                <td width=15%>
                                    <hr>Подпись
                                </td>
                            </tr>
                            <tr height=19px>
                                <td>
                                 <?= $game->team2->link; ?>
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                            </tr>
                            <tr height=19px>
                                <td width=35%>
                                    <hr>Команда
                                </td>
                                    
                                <td width=35%>
                                    <hr>Ф.И.О.
                                </td>
                                <td width=15%>
                                    <hr>Подпись
                                </td>
                            </tr>
                        </table>
                        
                        <table width=50%>
                            <tr height=19px>
                                <td>
                                  <?= $game->ref1->link;?>
                                </td>
                                <td>
                                    
                                </td>
                            </tr>
                            <tr height=19px>
                                <td width=35%>
                                    <hr>Первый судья
                                </td>
                                <td width=15%>
                                    <hr>подпись
                                </td>
                            </tr>
                            <tr height=19px>
                                <td>
                                   <?= $game->ref2->link;?>
                                </td>
                                <td>
                                    
                                </td>
                            </tr>
                            <tr height=19px>
                                <td width=35%>
                                    <hr>Второй судья
                                </td>
                                <td width=15%>
                                    <hr>подпись
                                </td>
                            </tr>
 
                        </table>
                    </td>
                </tr>
            </table>
<? endforeach; ?>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>