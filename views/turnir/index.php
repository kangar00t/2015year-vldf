<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Турниры';
?>

<div class="turnir-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= Yii::$app->user->can('admin') ? 
        Html::a('Создать турнир', ['create'], ['class' => 'btn btn-success']) :
        false; 
    ?>
    <table class="table table-striped">
        <tr>
            <th class="tu-name">Название</th>
            <th class="tu-date">Дата начала</th>
            <th class="tu-date">Дата завершения</th>
            <th class="tu-status">Статус</th>
        </tr>
    <?php foreach ($turnirs as $turnir) : ?>
        <tr>
            <td>
                <?= $turnir->link;?>
                <?//= count($turnir->turnirTeams) ? '':' [NO TEAMS]';?>
                <?//= count($turnir->games) ? '':' [NO GAMES]';?>
                <?//= count($turnir->games) ? '':' [NO STAT]';?>
            </td>
            <td><?= $turnir->started_at;?></td>
            <td><?= $turnir->ended_at;?></td>
            <td><?= $turnir->statusName;?></td>
        </tr>
    <?php endforeach; ?>
    </table>

</div>
