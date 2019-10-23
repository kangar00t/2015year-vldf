<?php

?>
<div class="turnir-best">
    
    <?= $model->showTitle();?>

    <? foreach($model->best as $best) : ?>
    	<p><?=$best['count'];?> - <?=$best['model']->lname;?></p>
	<? endforeach;?>

</div>