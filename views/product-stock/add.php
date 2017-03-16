<?php
use yii\widgets\ActiveForm;
use app\widgets\AlertMsgWidget;
use yii\helpers\Html;
?>
<div class="breadcrumbs" id="breadcrumbs">
	<script type="text/javascript">
		try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
	</script>

	<ul class="breadcrumb">
		<li>
			<i class="icon-home home-icon"></i>
			<a href="<?=Yii::$app->urlManager->createUrl('/product')?>">商品管理</a>
		</li>
		<li><?=$productName?></li>
		<li class="active">添加商品库存</li>
	</ul>
</div>

<div class="page-content">
	<div class="page-header">
		<h1>
			商品管理
			<small>
				<i class="icon-double-angle-right"></i>
				<?=$productName?>
			</small>
			<small>
				<i class="icon-double-angle-right"></i>
				添加商品库存
			</small>
		</h1>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal']])?>
				<?=AlertMsgWidget::widget(['view' => $this])?>
				<?=Html::hiddenInput('ProductStockForm[product_id]', $productStockForm->product_id)?>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 库存名称： </label>
					<div class="col-sm-6">
						<?=Html::textInput('ProductStockForm[name]', $productStockForm->name, ['class' => 'form-control'])?>
					</div>
					<div class="col-sm-3">
						<?php if ($productStockForm->hasErrors('name')):?>
							<span class="block error"><?=Html::error($productStockForm, 'name')?></span>
						<?php endif;?>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 初始化库存： </label>
					<div class="col-sm-6">
						<?=Html::textInput('ProductStockForm[num]', $productStockForm->num, ['class' => 'form-control'])?>
					</div>
					<div class="col-sm-3">
						<?php if ($productStockForm->hasErrors('num')):?>
							<span class="block error"><?=Html::error($productStockForm, 'num')?></span>
						<?php endif;?>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 库存名称： </label>
					<div class="col-sm-6">
						<?=Html::textInput('ProductStockForm[warning_num]', $productStockForm->warning_num, ['class' => 'form-control'])?>
					</div>
					<div class="col-sm-3">
						<?php if ($productStockForm->hasErrors('warning_num')):?>
							<span class="block error"><?=Html::error($productStockForm, 'warning_num')?></span>
						<?php endif;?>
					</div>
				</div>
				
				<div class="clearfix form-actions">
					<div class="col-md-offset-3 col-md-9">
						<button class="btn btn-info" type="submit">
							<i class="icon-ok bigger-110"></i>
							提交
						</button>
						&nbsp; &nbsp; &nbsp;
						<button class="btn" type="reset">
							<i class="icon-undo bigger-110"></i>
							重置
						</button>
					</div>
				</div>
			<?php ActiveForm::end()?>
		</div>
	</div>
</div>