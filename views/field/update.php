<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\Field */

$this->title = 'Редактирование площадки: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Fields', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="field-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="field-form">

        <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>
        
        <div class="imgUpload">
            <div class="file-preview">
                <?= $model->LogoImg(200);?>
            </div>
            
            <?= $form->field($model, 'img3')->widget(FileInput::classname(), [
                'options' => [
                    'accept' => 'img/fields/*',
                    'multiple'=>false
                ],
                'pluginOptions' => [
                    'previewFileType' => 'image',
                    'showCaption' => false,
                    'showRemove' => false,
                    'showUpload' => false,
                    'browseClass' => 'btn btn-primary imgUpload',
                    'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                    'browseLabel' =>  'Сменить фото'
            ],
            ])->label(false);?>
        </div>
    
        <?= $form->field($model, 'name')->textInput(['maxlength' => 32]) ?>
    
        <?= $form->field($model, 'address')->textarea(['rows' => 6]) ?>
    
        <?= $form->field($model, 'phone')->textInput() ?>
    
        <?= $form->field($model, 'map')->textInput(['maxlength' => 255]) ?>
    
        <?= $form->field($model, 'status')->textInput() ?>
    
        <?= $form->field($model, 'length')->textInput() ?>
    
        <?= $form->field($model, 'width')->textInput() ?>
    
        <?= $form->field($model, 'gale_width')->textInput() ?>
    
        <?= $form->field($model, 'gate_height')->textInput() ?>
    
        <?= $form->field($model, 'type_cover')->textInput() ?>
    
        <?= $form->field($model, 'type_room')->textInput() ?>
    
        <?= $form->field($model, 'cost')->textInput() ?>
    
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    
        <?php ActiveForm::end(); ?>
    
    </div>

</div>
