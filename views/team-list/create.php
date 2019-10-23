<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TeamList */

$this->title = 'Create Team List';
$this->params['breadcrumbs'][] = ['label' => 'Team Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="team-list-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
