<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Disq */

$this->title = $model->id;
?>
<div class="disq-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <? if (Yii::$app->user->can('admin')) : ?>
    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите БЕЗВОЗВРАТНО удалить запись о дисквалификации?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <? endif; ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'profile_id',
            'text',
            'status',
        ],
    ]) ?>

</div>
