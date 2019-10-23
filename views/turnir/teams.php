<?php
    use app\models\Turnir;
    use yii\helpers\Html;
    use yii\helpers\ArrayHelper;
        
?>

<?php if ($model->status == Turnir::STATUS_NEW) : ?>
<!-- Button trigger modal -->
    <div class="row" id="turnir-teams">
        Новый турнир. Прием заявок еще не начат.
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#my0Modal">
          Начать прием заявок
        </button>
    </div>
    
    <!-- Modal -->
    <div class="modal fade" id="my0Modal" tabindex="-1" role="dialog" aria-labelledby="my0ModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="my0ModalLabel">Уверены?</h4>
          </div>
          <div class="modal-body">
            После перевода турнира в статус "Приема заявок" турнир будет доступен командам.
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
            <button type="button" class="btn btn-success" id="status-start" name="<?=$model->id;?>">Начать прием заявок</button>
          </div>
        </div>
      </div>
    </div>
    
    <? $this->registerJs('
        $("#status-start").click(function(e){
            var id = $(this).attr("name");
            $.post("status-set/"+id, function(data) {
                if (data) {
                    $("#turnir-teams").html(data);
                } else
                    $("#turnir-teams").prepend("Неизвестная ошибка!");
                
                $("#my0Modal").modal("hide")
            });
        });
    '); ?>
<?php elseif($model->status == Turnir::STATUS_SET) : ?>

    <!-- Modal -->
    <div class="modal fade bs-example-modal-sm" id="my1Modal" tabindex="-1" role="dialog" aria-labelledby="my1ModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="my1ModalLabel">Выберите команду</h4>
          </div>
          <div class="modal-body" id="team-select">
            <?= Html::dropDownList('teams-list', '', ArrayHelper::map($model->teamsForUser, 'id', 'name')) ?>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
            <button type="button" class="btn btn-success" id="new-tteam" name="<?=$model->id;?>">Подать заявку</button>
          </div>
        </div>
      </div>
    </div>
    <? $this->registerJs('
        $("#new-tteam").click(function(e){
            var turnir = $(this).attr("name");
            var team = $("select[name=\'teams-list\']").val();
            
            $.post("add-team", {"turnir":turnir, "team":team}, function(data) {

                if (data) {
                    $("#turnir-teams").html(data);
                } else
                    $("#turnir-teams").prepend("Неизвестная ошибка!");
                
                $("#my1Modal").modal("hide")
                window.location.reload();
            });
        });
    '); ?>
    
    <div class="row" id="turnir-teams">
        <p>
            Открыт набот команд на участи в турнире.
            
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#my1Modal">
              Подать заявку
            </button>
        </p>
        Список команд, подавших заявки:
        <?php if (count($model->turnirTeams)) : ?>
        
        <?php foreach($model->turnirTeams as $tteam): ?>
            <p><?= $tteam->team->link;?></p>
        <?php endforeach; ?>
        
        <?php else : ?>
        
            <p>Нет команд</p> 
        <?php endif; ?>
    </div>
<?php endif; ?>