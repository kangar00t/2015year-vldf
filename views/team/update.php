<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Team */

$this->title = 'Update Team: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Teams', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="team-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="team-form">

        <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>
        <div class="imgUpload">
        <div class="file-preview">
            <?= $model->LogoImg(200);?>
        </div>
        
        <?= $form->field($model, 'logo3')->widget(FileInput::classname(), [
            'options' => [
                'accept' => 'img/emblems/*',
                'multiple'=>false
            ],
            'pluginOptions' => [
                'previewFileType' => 'image',
                'showCaption' => false,
                'showRemove' => false,
                'showUpload' => false,
                'browseClass' => 'btn btn-primary imgUpload',
                'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                'browseLabel' =>  'Сменить эмблему'
        ],
        ])->label(false);?>
        </div>
        
        <?= $form->field($model, 'name')->textInput(['maxlength' => 64]) ?>
        <?= $form->field($model, 'creator')->dropDownList(ArrayHelper::map($users, 'profile_id', function ($element) {
            return $element->username.' ('.$element->status.') '.$element->profileModel->fullName;
        })); ?>
    
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    
        <?php ActiveForm::end(); ?>
    
    </div>

</div>
