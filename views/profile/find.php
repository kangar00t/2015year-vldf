
<?php foreach ($profiles as $profile) : ?>
    <div class="profile-card">
        <img src="/img/avatars/<?= $profile->photo;?>.jpg" width="100px"/>
        <div class="info">
            <p class="p-name"><?= $profile->fullLink; ?></p>
            <p>Последние турниры:</p>
            <p><?= $profile->teamList->team->link; ?></p>
        </div>
        
    </div>
<?php endforeach; ?>

<? if (!count($profiles)) : ?>
    По вашему запросу не найдено игроков.
<? endif;?>

