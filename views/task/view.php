<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Task */

$this->title = $model->name;

?>
<div class="task-view">

    
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?php if ($model->parent) : ?>
                    <?php foreach($model->parentTasks as $task) : ?>
                        <?= $task->link; ?> >
                    <?php endforeach; ?>
                <?php endif; ?>
                <h1><?= Html::encode($this->title) ?></h1>
            </div>
        <div class="panel-body">
            <pre><?= $model->text;?></pre>
            <div class="col-lg-4 col-md-4 col-xs-6">
                <dl class="dl-horizontal">
                
                    <dt>Создана</dt>
                    <dd><?= $model->userCreator->profileModel->link; ?></dd>
                    
                    <dt>Исполнитель</dt>
                    <dd><?= $model->userPerformer->profileModel->link?:'не назначено'; ?></dd>
                    
                    <dt>Дэдлайн</dt>
                    <dd><?= $model->date_out?:'не установлен'; ?></dd>
                    
                    <dt></dt>
                    <dd><?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-xs']) ?></dd>
                    
                </dl>        
            </div>
            
            <div class="col-lg-8 col-md-8 col-xs-6">
                <dl>
                    <dt>Подзадачи</dt>
                    <dd>
                        <ol>
                            <?php foreach($model->tasks as $task) : ?>
                                <li><?= $this->context->fullLink($task->id); ?></li>
                            <?php endforeach; ?>
                        </ol>
                        <?= Html::a('+ Добавить подзадачу', ['task/create/'.$model->id], ['class' => 'btn-xs btn-default btn']); ?>
                    </dd>
                </dl>
            
            </div>
        
        </div>

    </div>
        
            <div class="col-lg-6 col-md-8 col-xs-12 col-lg-offset-3 col-md-offset-2">
                <?php foreach($messages as $message) : ?>
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <?= $message->user->profileModel->link; ?> написал <?= $message->date; ?>
                        </div>
                        <div class="panel-body">
                            <?= $message->text; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
                <div class="task-message-form">
                    <?php $form = ActiveForm::begin(); ?>
                        <?= $form->field($msg, 'text')->textarea(['rows' => 6]) ?>
                        <div class="form-group">
                            <?= Html::submitButton('Добавить сообщение', ['class' => 'btn btn-success']) ?>
                        </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        
    
    
</div>
