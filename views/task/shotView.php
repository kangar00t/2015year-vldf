<?php

use yii\helpers\Html;

?>

<span style="display:block; margin:3px 0 3px 10px; padding:3px; border: 1px solid #cccccc;">
    <?= $this->context->fullLink($model->id);?>

    <? foreach ($model->tasks as $task) : ?>
        <?= $this->context->showTasks($task->id); ?>
    <? endforeach; ?>
</span>