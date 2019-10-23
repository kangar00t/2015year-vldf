<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;

use app\components\widgets\PlayOff;
use app\models\Turnir;
use app\models\TurnirEtap;

/* @var $this yii\web\View */
/* @var $model app\models\Turnir */

?>
<div class="turnir-view">
    
    <?= $model->showTitle();?>
    
    <?//= $this->render('teams', ['model' => $model]); ?>
    
    <?php foreach($model->stages as $stage): ?>
    
        <p class="stage-name"><?= $stage->name ? $stage->name : ''?></p>
        

    <!-- Button trigger modal -->
    <?/*= Yii::$app->user->can('admin') ?
    
    '<p><button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#addEtap" data-stageid="<?= $stage->id;?>">
      Добавить Группу/Плэй-офф
    </button></p>'
     :
    false;    
    */?>        
        <?php if ($stage->isTable()) : ?>
            <? if (Yii::$app->user->can('admin') AND (!$stage->haveGames())) : ?>
            <p>
                <?= Html::a('Сгенерировать календарь', ['/turnir/generategames/'.$stage->id], ['class' => 'btn btn-success']);?>
            </p>
            <? endif; ?>
            <?php foreach($stage->etaps as $etap): ?>
            <div class="row">
                <?php if ($etap->type == 1) : ?>
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <div class="turnir-table">
                            <p><?= $etap->name; ?></p>
                            
                            <table class="table table-striped">
                                <tr>
                                    <th class="tt-int"></th>
                                    <th class="tt-name">Команда</th>
                                    <th class="tt-int">И</th>
                                    <th class="tt-int">В</th>
                                    <th class="tt-int">Н</th>
                                    <th class="tt-int">П</th>
                                    <th class="tt-int">З</th>
                                    <th class="tt-int">Пр</th>
                                    <th class="tt-int">О</th>
                                    <th class="tt-int"><span class="glyphicon glyphicon-eye-open"></span></th>
                                </tr>
                                
                                <?php foreach ($etap->turnirTable as $i => $ttable) : ?>
                                <tr>
                                    <td class="tt-int"><?= $i+1; ?></td>
                                    <td class="tt-name"><?= $ttable->team->linkImg; ?></td>
                                    <td class="tt-int"><?= $ttable->igr; ?></td>
                                    <td class="tt-int"><?= $ttable->pob; ?></td>
                                    <td class="tt-int"><?= $ttable->nich; ?></td>
                                    <td class="tt-int"><?= $ttable->por; ?></td>
                                    <td class="tt-int"><?= $ttable->zab; ?></td>
                                    <td class="tt-int"><?= $ttable->prop; ?></td>
                                    <td class="tt-int"><?= $ttable->och; ?></td>
                                    <td class="tt-int"><a class="show_table_game" data-etap="<?= $etap->id; ?>" data-team="<?=$ttable->team->id;?>"> >>> </a></td>
                                </tr>                        
                                <?php endforeach; ?>
                            </table>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <div class="table_games_<?=$etap->id;?>"></div>    
                    </div>
                <?php else : ?>
                    <?php foreach($etap->turnirTeams as $tteam): ?>
                        
                    <?php endforeach; ?>
                    <?= PlayOff::widget(['etap' => $etap]) ?>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
            
        <?php else : ?>
        
            <?php if ($stage->isStaffed()) : ?>
                Команды набраны.
                <?= Html::a('Сгенерировать таблицу', ['/turnir/generatestage/'.$stage->id], ['class' => 'btn btn-success']); ?>
            <?php else : ?>
                Команды не набраны.
            <?php endif; ?>

            <?php foreach($stage->etaps as $etap): ?>
                <p><?= $etap->name; ?> <span>(Команд:<?=count($etap->teams);?> из <?=$etap->teamCountMax(); ?>)</span></p>            
                <? if ($etap->teams): ?>
                    <?php foreach($etap->teams as $team): ?>
                        <p><?=$team->link; ?></p>                    
                    <?php endforeach; ?>                
                <? else: ?>
                    <?= Html::tag('p', 'Нет команд', ['class' => 'no-data']) ?>                
                <? endif; ?>            
            <?php endforeach; ?>
        <?php endif; ?>
    <?php endforeach; ?>

</div>

<!-- Окно добавления этапа -->
<div class="modal fade" id="addEtap" tabindex="-1" role="dialog" aria-labelledby="addEtapLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Добаление Группы/Плэй-офф</h4>
      </div>
      
      <?php 
            $newEtap = new TurnirEtap();
            $form = ActiveForm::begin([
                'layout' => 'horizontal',
                'id' => 'add-etap',
                'enableAjaxValidation' => true,
                'validationUrl' => ['validate-etap'],
                'action' => ['turnir-etap/create/'.$model->id],
            ]); 
        ?>
      <div class="modal-body">
            <?= $form->field($newEtap, 'name')->textInput(['maxlength' => 255]); ?>
            <?= $form->field($newEtap, 'type')->dropDownList(ArrayHelper::map($types, 'id', 'name'),['placeholder' => 'Выберите тип']); ?>
            <?= $form->field($newEtap, 'size')->textInput(); ?>   
            <?= $form->field($newEtap, 'sort')->textInput(); ?>
                                         
            <?= $form->field($newEtap, 'stage_id')->hiddenInput()->label(false); ?>
            <?= $form->field($newEtap, 'steps')->hiddenInput(['value' => '1'])->label(false); ?>
            <?= $form->field($newEtap, 'turnir_id')->hiddenInput(['value' => $model->id])->label(false); ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
        <?= Html::submitButton('Добавить', ['class' => 'btn btn-success']); ?>
      </div>
      <?php ActiveForm::end(); ?>
      
    </div>
  </div>
</div>

<? $this->registerJs('
    var team = $(".show_table_game:first").data("team");
    var etap = $(".show_table_game:first").data("etap");
    $.post("table-games", {"etap" : etap, "team" : team} , function(data) {
        $(".table_games_"+etap).html(data);
    });

    $(".show_table_game").click(function() {
        var team = $(this).data("team");
        var etap = $(this).data("etap");
        $.post("table-games", {"etap" : etap, "team" : team} , function(data) {
            $(".table_games_"+etap).html(data);
        });
    });
');
?>
<? /*$this->registerJs('
$("#addEtap").on("show.bs.modal", function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var recipient = button.data("stageid") // Extract info from data-* attributes
  var modal = $(this)
  modal.find(".modal-body input#turniretap-stage_id").val(recipient)
  
})');*/
?>