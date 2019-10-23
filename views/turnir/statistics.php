<?

use app\models\Profile;
use app\models\Team;

?>

<div class="turnir-view">
    
    <?= $model->showTitle();?>
        <div class="col-xs-6 col-sm-6 col-md-6">
            <h3>Таблица бомбардиров</h3>
            <? foreach($model->goalsArray() as $stat) : ?>
            <div class="row table-hover">
                <div class="col-xs-1 col-sm-1 col-md-1">
                    <?= $stat["ss"]; ?>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <?= Profile::findOne($stat["pl"])->link; ?>
                </div>
                <div class="col-xs-5 col-sm-5 col-md-5">
                    <?= Team::findOne($stat["tm"])->link; ?>
                </div>

            </div>
            <? endforeach; ?>
            
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6">
            <h3>Таблица нарушений</h3>
            <? foreach($model->cardsArray() as $stat) : ?>
            <div class="row">
                <div class="col-xs-5 col-sm-5 col-md-5">
                    <?= Profile::findOne($stat["pl"])->link; ?>
                </div>
                <div class="col-xs-2 col-sm-2 col-md-2" style="padding: 0px;">
                    <?=Profile::findOne($stat["pl"])->cardsImg($model->id);?>
                </div>
                <div class="col-xs-5 col-sm-5 col-md-5">
                    <?= Team::findOne($stat["tm"])->link; ?>
                </div>
            </div>
            <? endforeach; ?>
            
        </div>
</div>