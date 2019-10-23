<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\web\View;
use kartik\depdrop\DepDrop;

/* @var $this yii\web\View */
/* @var $model app\models\Turnir */

?>
<?= $turnir->showTitle();?>
<h2><?= 'Распределение команд турнира '.$turnir->Link; ?></h2>
<?= Html::a('Добавить', ['/turnir-team/create-turnir/'.$turnir->id]); ?>
    <?php $form = ActiveForm::begin([
        'id' => 'form-tteams',
        'fieldConfig' => [
            'template' =>
                "{input}",
        ],
    
    ]); ?>
    <? foreach($turnir->stages as $stage): ?>
        Уровень <?=$stage->sort;?>
        <? foreach($stage->turnirTeams as $i=>$tteam): ?>
        <div class="dl-horizontal">
            <div class="h-block" style="width: 150px;"><?= $tteam->team->link;?></div>
            <div class="h-block" style="width: 150px;">
                <?= $form->field(
                    $tteam, 
                    "[$stage->id$i]etap_id")->dropDownList(
                        ArrayHelper::merge(
                            ['0' => 'Не участвует'],
                            ArrayHelper::map($stage->etaps, 'id', 'name')
                        ),
                        ['id'=>"etap-id$stage->id$i"]
                    ); 
                ?>
            </div>
            <div class="h-block" style="width: 120px;">
                <?= $form->field($tteam, "[$stage->id$i]position")->widget(DepDrop::classname(), [
                    'data' => [$tteam->position => $tteam->position],
                    'options' => ['id'=>"etapsize-id$stage->id$i"],
                    'pluginOptions'=>[
                        'depends'=>["etap-id$stage->id$i"],
                        'placeholder' => '0',
                        'url' => Url::to(['/turnir-etap/position-array'])
                    ]
                    ]);
                ?>
                <?= $form->field($tteam, "[$stage->id$i]id")->hiddenInput(); ?>
            </div>
            <div class="h-block" style="width: 50px;">
                <?= Html::a('Заявка', ['/team-list/turnir/'.$tteam->id]) ?>
            </div>
        </div>
        
        <? endforeach; ?>
    <? endforeach; ?>
    
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'name' => 'tteams-button']) ?>
    </div>

<?php ActiveForm::end(); ?>
<?php
    /*$this->registerJs('
        $(\'select\').change(function(){
        alert($(this).val());
    
    });', View::POS_READY);*/
?>