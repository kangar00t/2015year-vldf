Заявка команды <?= $team->link; ?> на турнир <?= $turnir->link; ?>

<?php if (count($tteam->teamList)) : ?>
    <?php foreach($tteam->teamList as $tlist) : ?>
        <?= $tlist->profile->link; ?>
    <?php endforeach; ?>
    
<?php else : ?>
    <p>В заявке нет игроков.</p>
<?php endif; ?>