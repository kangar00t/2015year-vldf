<? foreach ($tlists as $tlist) : ?>
    <? if (!$tlist->date_out) : ?>
        <p><?=$tlist->date_out;?> <?=$tlist->profile->link;?> (<?= $tlist->team->link;?>)</p>
    <? endif;?>
<? endforeach; ?>