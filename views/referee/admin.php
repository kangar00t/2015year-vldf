<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
?>

<? 
    $date = 0;
    $field = 0;   
?>
<?php $form = ActiveForm::begin(); ?>
    <? foreach ($games as $i => $game) : ?>
    
    <? if (!($date == $game->date) OR ($field != $game->field_id)) : ?>
    <?
        $date = $game->date;
        $field = $game->field_id; 
    ?>
    </table>
    <h3><?=$game->field->name;?> <?=$game->date;?></h3>
    <? endif; ?>   
    
    <div class="referee-admin">
        <div class="h-block" style="width: 200px;">
            <p class="r-time"><?= $game->time;?></p>
            <p><?= $game->turnir->link;?> (<?= $game->tur;?> тур)
        </div>
        <div class="h-block" style="width: 200px;">
            <p><?= $game->team1->link;?></p>
            <p><?= $game->team2->link;?></p>
        </div>

        <div class="h-block" style="width: 500px; padding-top: 5px;">
           <?= $form->field($game, "[$i]ref_id")->dropDownList(ArrayHelper::map($referees, 'profile_id', function($element) {return $element->profile->fullName;}) ,['prompt'=>'...'])->label(false); ?>
            <?= $form->field($game, "[$i]ref2_id")->dropDownList(ArrayHelper::map($referees, 'profile_id', function($element) {return $element->profile->fullName;}) ,['prompt'=>'...'])->label(false); ?>
        </div>
    </div>
    <? endforeach; ?>
    <div class="form-group referee-admin-btn">
        <?= Html::submitButton('Сохранить', ['btn btn-primary']) ?>
    </div>
<?php ActiveForm::end(); ?>