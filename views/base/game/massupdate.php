<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;
use kartik\time\TimePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Game */

?>
<div class="game-update">

    <div class="game-form">
        <?php $form = ActiveForm::begin(); ?>
        <table class="table table-striped">
            <tr>
                <th class="tc-tur">Тур</th>
                <th class="tc-field">Площадка</th>
                <th class="tc-time">Время</th>                
                <th class="tc-date">Дата</th>
                <th class="tc-team1">Команда</th>
                <th class="tc-goals">Счет</th>
                <th class="tc-team2">Команда</th>
            </tr>       
            <? foreach($games as $i=>$game) : ?>

            <tr>
                <td class="tc-tur"><?=$game->tur;?></td>
                <td class="tc-tur">
                    <?= $form->field($game, "[$game->id$i]field_id")->dropDownList(
                        ArrayHelper::map($fields, 'id', 'name') ,
                        ['prompt'=>'Выберите площадку из списка...']
                    ); ?>
                </td>
                <td class="tc-time">
                <?= $form->field($game, "[$game->id$i]time")->widget(
                    TimePicker::classname(), 
                    [
                        'name' => 't1',
                        'class' => 'game-time',
                        'pluginOptions' => [
                            'showSeconds' => false,
                            'showMeridian' => false,
                            'minuteStep' => 5,
                        ]
                    ]
                ); ?>
                </td>
                <td class="tc-date">
                <?= $form->field($game, "[$game->id$i]date")->widget(
                    DatePicker::className(),
                    [
                      'language' => 'ru',
                      'clientOptions' => [
                        'changeYear' => true,
                        'changeMonth' => true,
                        'yearRange' => "2000:2025"
                      ],
                      'dateFormat' => 'yyyy-MM-dd',
                    ]
                ); ?>
                </td>
                
                <td class="tc-team1"><?=$game->team1->link;?></td>
                <td class="tc-goals"><?=$game->gol1;?> - <?=$game->gol2;?></td>
                <td class="tc-team2"><?=$game->team2->link;?></td>
            </tr>
            <?php endforeach; ?>
        
            </table>
        
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    
        <?php ActiveForm::end(); ?>
    </div>
</div>

<? $this->registerJs('
    $("input[name*=\'time\']").val("");
');