<?php use yii\helpers\Html; ?>

<div class="row">
    <div class="col-lg-2 col-md-3 col-xs-6">
            <ul class="list-unstyled">
                <li>
                    <?= Html::a('Дерево', ['task/all'], ['class' => 'btn-link btn']); ?>
                </li>
                <li>
                    ГоД
                    <?= Html::a('Годунов', ['task/user/16'], ['class' => 'btn-link btn']); ?>
                </li>
                <li>
                    Ил
                    <?= Html::a('Ерофеев', ['task/user/18'], ['class' => 'btn-link btn']); ?>
                </li>
                <li>
                    Ежъ
                    <?= Html::a('Спиридонов', ['task/user/17'], ['class' => 'btn-link btn']); ?>
                </li>
                <li>
                    Шыш
                    <?= Html::a('Шишкин', ['task/user/22'], ['class' => 'btn-link btn']); ?>
                </li>
                <li>
                    <?= Html::a('Горящие', ['index'], ['class' => 'btn-link btn disabled']); ?>
                </li>
                <li>
                    <?= Html::a('Завершенные', ['index'], ['class' => 'btn-link btn disabled']); ?>
                </li>
                <li>
                    <?= Html::a('Требуют обсуждения', ['xuaction'], ['class' => 'btn-link btn']); ?>
                </li>
                <li>
                    <?= Html::a('Без назначения', ['task/no-performer'], ['class' => 'btn-link btn']); ?>
                </li>
                <li>
                    <?= Html::a('Без сроков', ['task/no-date'], ['class' => 'btn-link btn']); ?>
                </li>
            </ul>
        </div>
    <div class="col-lg-10 col-md-9 col-xs-6">
        <ul class="list-group">
            <? foreach($tasks as $task) : ?>
                <li class="list-group-item">
                    <?= $this->context->showTasks($task->id);?>
                </li>
            <? endforeach; ?>
        </ul>
    </div>
</div>