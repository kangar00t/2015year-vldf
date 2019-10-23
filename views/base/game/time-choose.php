<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;


?>
<div class="row">
    <h3>Выбор времени матча <?= $game->team1->link ?> - <?= $game->team2->link ?></h3>
    <p>Дата: <?= $game->turDate->date;?></p>
    <p>Поле: <?= $game->turDate->field->name;?> </p>
    <? if ($game->yourTeam) : ?>
        <p>Ваша команда: <?= $game->yourTeam->link; ?></p>
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6">
                <?php $form = ActiveForm::begin(); ?>
                    <?= Html::checkbox('perenos', false, ['label' => 'Перенос игры ( или отмена тура ) при не совпадении.']); ?>
                    <p>Ставя галочку выше вам будет позволено выбрать более 4 вариантов "не можем". 
                    При этом, если ваш выбор не будет иметь совпадений с выбором соперника, 
                    или ваш выбор не позволит поставить игру на один из вариантов 
                    (они будут слишком популярны у команд), игра будет перенесена по вашей инициативе.
                    <br />Для переноса(отмены) выберите "не можем" для всех вариантов времени.
                    </p>
                    <div>
                        <div class="h-block" style="width: 80px;">Время</div>
                        <div class="h-block" style="width: 200px;">
                            Ваш выбор
                        </div>
                        <div class="h-block" style="width: 150px;">
                            Выбор соперника
                        </div>
                    </div>
                    <? foreach ($chooses as $i=>$choose) : ?>
                    <div>
                        <div class="h-block" style="width: 80px;"><?= $choose->time->time; ?></div>
                        <div class="h-block" style="width: 200px;">
                            <?= $form->field($choose, "[$i]choose")->dropDownList([
                                '2' => 'Удобно',
                                '1' => 'Можем',
                                '0' => 'Не можем',
                            ])->label(false); ?>
                        </div>
                        <div class="h-block" style="width: 150px;">
                            <?= $rchooses[$i] ? $rchooses[$i]->chooseName : 'Выбор не сделан'; ?>
                        </div>
                    </div>
                    <? endforeach; ?>
                    <div class="form-group">
                        <?= Html::submitButton('Сохранить выбор', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                    </div>
                <?php ActiveForm::end(); ?>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6">
                <p>Немного о системе выбора времени:</p>
                <p>Командам предоставляется отметить варианты времени начала матча, как "удобное", "можем" и "не можем.
                Вариантов "не можем" команда может выбрать только четыре, в противном случае вероятно отсутствие пересечений
                выбора с соперником. Команде гарантируется, что их матч не будет поставлен на вариант "не можем" без согласования с ними.
                Приоритетно время будет поставлено на "удобный" вариант, но только при наличии возможности. Как показывает практика, это бывает
                 чуть меньше, чем в 50% случаев.</p>
            </div>
        </div>
    <? else : ?>
        Вы не являетесь администратором ни одной из команд данного матча.
    <? endif ?>
</div>