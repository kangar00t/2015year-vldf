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
        
        <div class="col-xs-8 col-sm-8 col-md-8">
        <div class="row">
            <div class="col-xs-2 col-sm-2 col-md-2">
                <?= $model->team1->logoImg(70);?>
            </div>
            <div class="col-xs-4 col-sm-4 col-md-4">
                <?= $model->team1->sizelink(18);?>
                <?= $form->field($model, 'gol1')->textInput() ?>
                <?= $form->field($model, 'pen1')->textInput() ?>
                <?= $form->field($model, 'tehn1')->checkbox() ?>
            </div>
            
            <div class="col-xs-4 col-sm-4 col-md-4">
                <?= $model->team2->sizelink(18);?>
                <?= $form->field($model, 'gol2')->textInput() ?>
                <?= $form->field($model, 'pen2')->textInput() ?>
                <?= $form->field($model, 'tehn2')->checkbox() ?>
            </div>
            <div class="col-xs-2 col-sm-2 col-md-2">
                <?= $model->team2->logoImg(70);?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6" style="padding: 0;">
            
                <div class="h-block" style="width: 20px;">
                    +/-
                </div>
                <div class="h-block" style="width: 125px;">
                    Игрок
                </div>
                <div class="h-block" style="width: 45px;">
                    Голы
                </div>
                <div class="h-block" style="width: 80px;">
                    Карточки
                </div>
                
                <? foreach ($stat as $i=>$t1stat) : ?>
                    <? if ($t1stat->team_id == $model->team1_id) : ?>
                    <div class="clear"></div>
                    <div class="h-block" style="width: 20px;">
                        <?= $form->field($t1stat, "[$t1list->id$i]isLoad")->checkbox()->label(false); ?>
                    </div>
                    <div class="h-block" style="width: 120px;">
                        <?=$t1stat->profile->link;?>
                    </div>
                    <div class="h-block" style="width: 45px;">
                        <?= $form->field($t1stat, "[$t1list->id$i]goals")->textInput()->label(false); ?>
                    </div>
                    <div class="h-block" style="width: 73px;">
                        <?= $form->field($t1stat, "[$t1list->id$i]cards")->dropDownList([
                            '0' => 'Нет',
                            '1' => 'Ж',
                            '2' => '2Ж',
                            '3' => 'К',
                        ])->label(false); ?>
                    </div>
                    <div class="h-block" style="width: 20px;">
                        <?= $form->field($t1stat, "[$t1list->id$i]is_best")->checkbox()->label(false); ?>
                    </div>
                    <?= $form->field($t1stat, "[$stage->id$i]game_id")->hiddenInput()->label(false); ?>
                    <?= $form->field($t1stat, "[$stage->id$i]team_id")->hiddenInput()->label(false); ?>
                    <?= $form->field($t1stat, "[$stage->id$i]profile_id")->hiddenInput()->label(false); ?>
                    <?= $form->field($t1stat, "[$stage->id$i]id")->hiddenInput()->label(false); ?>
                    <? endif; ?>
                <? endforeach; ?>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6" style="padding: 0;">
                <div class="h-block" style="width: 20px;">
                    +/-
                </div>
                <div class="h-block" style="width: 125px;">
                    Игрок
                </div>
                <div class="h-block" style="width: 45px;">
                    Голы
                </div>
                <div class="h-block" style="width: 80px;">
                    Карточки
                </div>
                
                <? foreach ($stat as $i=>$t1stat) : ?>
                    <? if ($t1stat->team_id == $model->team2_id) : ?>
                    <div class="clear"></div>
                    <div class="h-block" style="width: 20px;">
                        <?= $form->field($t1stat, "[$t1list->id$i]isLoad")->checkbox()->label(false); ?>
                    </div>
                    <div class="h-block" style="width: 120px;">
                        <?=$t1stat->profile->link;?>
                    </div>
                    <div class="h-block" style="width: 45px;">
                        <?= $form->field($t1stat, "[$t1list->id$i]goals")->textInput()->label(false); ?>
                    </div>
                    <div class="h-block" style="width: 73px;">
                        <?= $form->field($t1stat, "[$t1list->id$i]cards")->dropDownList([
                            '0' => 'Нет',
                            '1' => 'Ж',
                            '2' => '2Ж',
                            '3' => 'К',
                        ])->label(false); ?>
                    </div>
                    <div class="h-block" style="width: 20px;">
                        <?= $form->field($t1stat, "[$t1list->id$i]is_best")->checkbox()->label(false); ?>
                    </div>
                    <?= $form->field($t1stat, "[$stage->id$i]game_id")->hiddenInput()->label(false); ?>
                    <?= $form->field($t1stat, "[$stage->id$i]team_id")->hiddenInput()->label(false); ?>
                    <?= $form->field($t1stat, "[$stage->id$i]profile_id")->hiddenInput()->label(false); ?>
                    <?= $form->field($t1stat, "[$stage->id$i]id")->hiddenInput()->label(false); ?>
                    <? endif; ?>
                <? endforeach; ?>
            </div>
        </div> 
        </div>
        

        <div class="col-xs-4 col-sm-4 col-md-4">
            <p><?= $model->turnir->link;?></p>
            <p>Тур: <?= $model->tur;?></p>
            <p><?= $model->etap->name;?></p>
    
    
        
            <?= $form->field($model, 'field_id')->dropDownList(ArrayHelper::map($fields, 'id', 'name') ,['prompt'=>'Выберите площадку из списка...']); ?>
        
            <?= $form->field($model, 'date')->widget(
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
        
            <?= $form->field($model, 'time')->widget(
                TimePicker::classname(), 
                [
                    'name' => 't1',
                    
                    'pluginOptions' => [
                        'showSeconds' => false,
                        'showMeridian' => false,
                        'minuteStep' => 5,
                    ]
                ]
            ); ?>
            <? if (Yii::$app->user->can('admin')) : ?>
                <?= $form->field($model, 'ref_id')->dropDownList(ArrayHelper::map($referees, 'profile_id', function($element) {return $element->profile->fullName;}) ,['prompt'=>'Выберите судью из списка...']); ?>
                <?= $form->field($model, 'ref2_id')->dropDownList(ArrayHelper::map($referees, 'profile_id', function($element) {return $element->profile->fullName;}) ,['prompt'=>'Выберите судью из списка...']); ?>
                <?= $form->field($model, 'kom_id')->dropDownList(ArrayHelper::map($referees, 'profile_id', function($element) {return $element->profile->fullName;}) ,['prompt'=>'Выберите комиссара...']); ?>
            <? endif; ?>
        </div>    
    
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    
        <?php ActiveForm::end(); ?>
    
    </div>

</div>

<? if (!$model->time)$this->registerJs('
    $("#game-time").val("");
');
?>