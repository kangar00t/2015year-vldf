<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Assn */

$this->title = 'Create Assn';
$this->params['breadcrumbs'][] = ['label' => 'Assns', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="assn-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
