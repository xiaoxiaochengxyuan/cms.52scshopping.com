<?php
use yii\helpers\Html;
?>
<?php if ($form->hasErrors($attribute)):?>
	<span class="block error"><?=Html::error($form, 'title')?></span>
<?php endif;?>