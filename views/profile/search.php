<?php
    use yii\helpers\Html;
?>

<?php foreach ($profiles as $profile) : ?>
    <div class="profile-card">
        <img src="/img/avatars/<?= $profile->photo;?>.jpg" width="100px"/>
        <div class="info">
            <div class="p-name"><?= $profile->fullLink; ?></div>
            <p>Последние турниры:</p>
            <p><?= $profile->teamList->team->link; ?></p>
            <p><?= Html::submitButton('Выбрать', [
                'href' => '#add-tlist',
                'class' => 'btn btn-success add-team-list', 
                'name' => $profile->id, 
                'onclick' => '
                    $("#teamlist-profile_id").val('.$profile->id.');
                    $("#profile-lname").val("'.$profile->lname.'");
                    $("#profile-fname").val("'.$profile->fname.'");
                    $("#profile-sname").val("'.$profile->sname.'");
                    $("#profile-birthday").val("'.$profile->birthday.'");
                ',
            ]) ?></p>
        </div>
        
    </div>
<?php endforeach; ?>

