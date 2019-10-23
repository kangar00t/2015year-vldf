<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Привязка прав';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-assignment-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'item_name',
            'login' => [
                'attribute'=>'user_id',
                'label'=>'Логин',
                'content'=>function($data){
                    return $data->user->username;
                }
            ] ,
            'profile' => [
                'attribute'=>'user_id',
                'label'=>'Профиль',
                'content'=>function($data){
                    return $data->user->profileModel->link;
                }
            ] ,

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
