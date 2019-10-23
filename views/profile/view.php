<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Profile */

$this->title = $model->fullName;

?>
<div class="profile-view">

    <div class="col-md-3">
        <?= $model->avatar(200); ?> 
        <p><?//= $model->avatar2(200); ?> </p>
        
    </div>
    <div class="col-md-9">
        <h1><?= Html::encode($this->title) ?></h1>
        <?/*= $model->user_id;*/?>
        <? If ((Yii::$app->user->can('admin')) OR ($model->id == Yii::$app->user->identity->profile_id) OR ($model->canUpdate())) : ?> 
            <p>
                <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn']) ?>
            </p>
        <? endif; ?>
        <div>
            <? if ($model->referee) : ?>
                Является <?= Html::a('судьей', ['/referee/'.$model->referee->id]) ?> соревнований.
            <? endif; ?>
        </div>
        <div>
            <? if (count($model->teamsCreated)) : ?>
                Является управляющим следующих команд:
                <? foreach ($model->teamsCreated as $team) : ?>
                    <p><?= $team->link; ?></p>
                <? endforeach; ?>
            <? endif; ?>
        </div>
        
        <? foreach ($model->teamLists as $tlist) : ?>
            <div class="tlist-item">
                <p class="team">
                    <?= $tlist->team->link; ?>
                </p>
                <p class="turnir">
                    <?= $tlist->turnir->link; ?>
                </p>
            </div>
        <? endforeach; ?>
    </div>
    

</div>
