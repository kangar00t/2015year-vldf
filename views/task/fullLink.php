<?php
use yii\helpers\Html;

$color = 'none';
if (!(strpos($model->diffDate(),'+') === false)) $color = '#ffbbbb';
if ($model->status == 3) $color = '#9bf9a4';
if ($model->status == 6) $color = '#ffff00';
?>

<span style="display: block; background-color:<?=$color?>;">
<?php if (Yii::$app->user->identity->id == $model->performer) : ?>
    <img 
        src="/img/pac-blu.png" 
        alt="<?= $model->userPerformer->profileModel->lname;?>"
        width="15" height="15" 
    />
<?php endif; ?>
<?php if ($model->performer == 16) : ?>
    ГоД
<?php elseif ($model->performer == 17) : ?>
    Ежъ
<?php elseif ($model->performer == 18) : ?>
    Ил
<?php elseif ($model->performer == 22) : ?>
    Шыш
<?php endif; ?>

<?php if ($model->status == 3) : ?>
   <span class="glyphicon glyphicon-ok"></span>
<?php endif; ?>
    
<?= $model->diffDate() ?>
&nbsp;
<?= Html::a($model->name, ['/task/'.$model->id], ['class' => '']); ?>
<?php if (count($model->tasks)) : ?>
    <span class="badge"><?= count($model->tasks); ?></span>
<?php endif; ?>
</span>