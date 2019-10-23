<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\Doc */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="doc-form">

    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>

    <?= $form->field($model, 'doc')->widget(FileInput::classname(), [
            'options' => [
                'accept' => 'doc/*',
                'multiple'=>false
            ],
            'pluginOptions' => [
                'previewFileType' => 'file',
                'showCaption' => false,
                'showRemove' => false,
                'showUpload' => false,
                'browseClass' => 'btn btn-primary imgUpload',
                'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                'browseLabel' =>  'Выбрать файл'
        ],
        ])->label(false);?>
    <p style="font-style: italic;">Допустимые форматы загружаемых файлов: PDF, DOC, DOCX, XLS, XLSX</p>
    <?= $form->field($model, 'text')->textInput(['maxlength' => 255]) ?>        

    <?= $form->field($model, 'name')->hiddenInput(['maxlength' => 32])->label(false) ?>

    <?= $form->field($model, 'status')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'type')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'type_id')->hiddenInput()->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить изменения', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
