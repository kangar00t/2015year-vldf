<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use kartik\file\FileInput;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Profile */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="profile-form">

    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>
        <div class="imgUpload">
        <div class="file-preview">
            <?= $model->Avatar(200);?>
        </div>
        
        <?= $form->field($model, 'logo3')->widget(FileInput::classname(), [
            'options' => [
                'accept' => 'img/avatars/*',
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

    <?= $form->field($model, 'lname')->textInput(['maxlength' => 32]) ?>
        
    <?= $form->field($model, 'fname')->textInput(['maxlength' => 32]) ?>

    <?= $form->field($model, 'sname')->textInput(['maxlength' => 32]) ?>

    <?= $form->field($model, 'birthday')->widget(
            DatePicker::className(),
            [
              'language' => 'ru',
              'clientOptions' => [
                'changeYear' => true,
                'changeMonth' => true,
                'yearRange' => "1955:2015"
              ],
              'dateFormat' => 'yyyy-MM-dd',
            ]
        ) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
