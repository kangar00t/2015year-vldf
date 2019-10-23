<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Turnir */

?>
<div class="turnir-update">

    <?= $model->showTitle();?>

    <?= $this->render('_form', [
        'model' => $model,
        'creators' => $creators,
    ]) ?>

</div>
