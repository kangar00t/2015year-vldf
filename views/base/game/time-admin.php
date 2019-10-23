<?
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
?>

<h3>Составление расписания</h3>

<div class="row">
    <? if (count($games)) : ?>
        <? $turnir = 0 ?>
        <?php $form = ActiveForm::begin(); ?>
            <? Foreach ($games as $i=>$game) : ?>
                <? if ($turnir != $game->turnir_id) {
                    $turnir = $game->turnir_id;
                    echo '<hr/>';
                } ?>
                <div style="height: 26px;">
                    <p style="display: inline-block; width: 350px;">
                        <?= $game->link; ?> <?= $game->team1->link; ?> <?= $game->gol1; ?>-<?= $game->gol2; ?> <?= $game->team2->link; ?>
                    </p>
                    <? Foreach ($game->chooseTeams as $choose) : ?>
                        <?= $choose; ?>
                    <? endforeach; ?>
                    <?= $form->field($game, "[$i]tur_time_id")->hiddenInput(["style" => "display: inline-block; width: 130px;"])->label(false); ?>
                </div>
            <? endforeach; ?>
        <div class="form-group">
            <?= Html::submitButton('Сохранить выбор', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    <? else : ?>
        Нет матчей для выбора времени.
    <? endif ?>
</div>

<? $this->registerJs('
    $(".chooses_val").click(function(){
        var time = $(this).attr("name");
        $(this).parent().children("div").children("input").val(time);
        $(this).parent().children(".chooses_val").removeClass("border");
        $(this).addClass("border");
  
    });
');