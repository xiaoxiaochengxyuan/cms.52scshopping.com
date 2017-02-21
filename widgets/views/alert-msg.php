<?php if (!empty($view->params['err'])):?>
	<?php foreach ($view->params['err'] as $e):?>
		<div class="alert alert-danger">
			<button type="button" class="close" data-dismiss="alert">
				<i class="icon-remove"></i>
			</button>
			<strong>错误!</strong>
			<?=$e?>
			<br>
		</div>
	<?php endforeach;?>
<?php endif;?>

<?php if (!empty($view->params['warn'])):?>
	<?php foreach ($view->params['warn'] as $w):?>
		<div class="alert alert-warning">
			<button type="button" class="close" data-dismiss="alert">
				<i class="icon-remove"></i>
			</button>
			<strong>警告!</strong>
			<?=$w?>
			<br>
		</div>
	<?php endforeach;?>
<?php endif;?>

<?php if (!empty($view->params['succ'])):?>
	<?php foreach ($view->params['succ'] as $s):?>
		<div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert">
				<i class="icon-remove"></i>
			</button>
			<strong>成功!</strong>
			<?=$s?>
			<br>
		</div>
	<?php endforeach;?>
<?php endif;?>