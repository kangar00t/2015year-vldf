<?php
    use yii\helpers\Html;
    use yii\bootstrap\ActiveForm;
?>

<h3>Заявка команды <?= $tteam->team->link; ?> на турнир <?= $tteam->turnir->link; ?></h3>


<div class="col-md-12">
    <div class="team-list-u">    
        <?php $form = ActiveForm::begin(); ?>
        <?php if (count($tteam->teamList)) : ?>
        <p>Проверено: <?= $form->field($tteam, "test")->dropDownList([0 => 'Нет',1 =>'Да'])->label(false); ?></p>
        
            В заявке <?= count($tteam->teamList); ?> человек.
            <div style="background-color: #ccc;
                        margin-bottom: 20px;">
                <div class="h-block" style="width: 250px;">
                    Игрок
                </div>
                <div class="h-block" style="width: 150px;">
                    Дозаявка
                    <div class="check-on check-on-all-1"></div>
                    <div class="check-off check-off-all-1"></div>
                </div>
                <div class="h-block" style="width: 150px;">
                    Паспорт
                    <div class="check-on check-on-all-2"></div>
                    <div class="check-off check-off-all-2"></div>
                </div>
            </div>
            
            <?php foreach($tteam->teamList as $i=>$tlist) : ?>
            <hr style="margin: 0px;" />
                <div>
                    <div class="h-block" style="width: 250px;">
                        
                        <?= $tlist->profile->link; ?>
                    </div>
                    <div class="h-block" style="width: 150px;">
                        <? if ($tlist->added): ?>
                            <div class="check-on check-img all-1"></div>
                        <? else: ?>
                            <div class="check-off check-img all-1"></div>
                        <? endif; ?>
                        
                        <?= $form->field($tlist, "[$i]added")->hiddenInput([0 => 'Нет',1 =>'Да'])->label(false); ?>
                    </div>
                    <div class="h-block" style="width: 150px;">
                        <? if ($tlist->profile->status) : ?>
                            <div class="check-on check-img all-2"></div>
                        <? else: ?>
                            <div class="check-off check-img all-2"></div>
                        <? endif; ?>
                        <?= $form->field($tlist->profile, "[$i]status")->hiddenInput()->label(false); ?>
                    </div>
                    <?= $form->field($tlist, "[$i]id")->hiddenInput()->label(false); ?>
                    <?= $form->field($tlist->profile, "[$i]id")->hiddenInput()->label(false); ?>
                    
                </div>
            <?php endforeach; ?>
            
        <?php else : ?>
            <p>В заявке нет игроков.</p>
        <?php endif; ?>
        <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    </div>
</div>


   


<? $this->registerJs('
    $(".check-img").bind("click", function() {
        
        if ($(this).hasClass("check-off")) {
            $(this).removeClass("check-off")
            $(this).addClass("check-on")
            $(this).parent().children(".form-group").children("input").val(1)
        }
        else {
            $(this).removeClass("check-on")
            $(this).addClass("check-off")
            $(this).parent().children(".form-group").children("input").val(0)
        }
    });
    
    $(".check-on-all-1").click(function() {
        $(".all-1").each(function(index, element) {
            $(element).removeClass("check-off")
            $(element).addClass("check-on")
            $(element).parent().children(".form-group").children("input").val(1)
        });
    });
    
    $(".check-off-all-1").click(function() {
        $(".all-1").each(function(index, element) {
            $(element).removeClass("check-on")
            $(element).addClass("check-off")
            $(element).parent().children(".form-group").children("input").val(0)
        });
    });
    $(".check-on-all-2").click(function() {
        $(".all-2").each(function(index, element) {
            $(element).removeClass("check-off")
            $(element).addClass("check-on")
            $(element).parent().children(".form-group").children("input").val(1)
            
        });
    });
    
    $(".check-off-all-2").click(function() {
        $(".all-2").each(function(index, element) {
            $(element).removeClass("check-on")
            $(element).addClass("check-off")
            $(element).parent().children(".form-group").children("input").val(0)
        });
    });

');
?>