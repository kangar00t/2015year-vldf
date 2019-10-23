
<?php foreach ($teams as $team) : ?>
    <div class="profile-card">
        <? $team->LogoImg(); ?>
        <div class="info">
            <p class="p-name"><?= $team->link; ?></p>
        </div>
        
    </div>
<?php endforeach; ?>

<? if (!count($teams)) : ?>
    По вашему запросу не найдено игроков.
<? endif;?>