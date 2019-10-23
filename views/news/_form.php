<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use yii\helpers\ArrayHelper;
use dosamigos\tinymce\TinyMce;

/* @var $this yii\web\View */
/* @var $model app\models\News */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="news-form">

    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>
    
    <?= $form->field($model, 'status')->dropDownList([
        0 => 'скрыта',
        1 => 'активна',
        2 => 'прикреплена',
        3 => 'на главной',
    ]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'text')->widget(TinyMce::className(), [
     'options' => ['rows' => 6], 
     'language' => 'ru', 
     'clientOptions' => [ 
        'plugins' => [ 
            'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen',
            'insertdatetime media nonbreaking save table contextmenu directionality',
            'emoticons template paste textcolor colorpicker textpattern imagetools'
        ], 
        'toolbar' => 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | forecolor backcolor emoticons',
        'toolbar2' => 'print preview media | forecolor backcolor emoticons',
        ] 
     ]);
     ?>

    <?= $form->field($model, 'logo3')->widget(FileInput::classname(), [
                'options' => [
                    'accept' => 'img/news/*',
                    'multiple'=>false
                ],
                'pluginOptions' => [
                    'previewFileType' => 'image',
                    'showCaption' => false,
                    'showRemove' => false,
                    'showUpload' => false,
                    'browseClass' => 'btn btn-primary imgUpload',
                    'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                    'browseLabel' =>  'Загрузить фото'
            ],
            ])->label(false);?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
