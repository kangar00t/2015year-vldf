<?php

?>
<div class="turnir-tehn">
    
    <?= $model->showTitle();?>

    <? foreach($model->gamesTehn as $game) : ?>
    	<p>(<a href="/game/<?=$game->id;?>">Матч</a>) <?=$game->looser()->link;?></p>
	<? endforeach;?>


</div>