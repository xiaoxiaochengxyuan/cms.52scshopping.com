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
			<a href="<?=Yii::$app->urlManager->createUrl('/product-cat')?>">商品分类管理</a>
		</li>
		<li class="active"><?=$this->title?></li>
	</ul>
</div>

<div class="page-content">
	<div class="page-header">
		<h1>
			商品分类管理
			<small>
				<i class="icon-double-angle-right"></i>
				<?=$this->title?>
			</small>
		</h1>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal']])?>
				<?=AlertMsgWidget::widget(['view' => $this])?>
				<?=Html::hiddenInput('ProductCatForm[pid]', $productCatForm->pid)?>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 分类名称： </label>
					<div class="col-sm-6">
						<?=Html::textInput('ProductCatForm[name]', $productCatForm->name, ['class' => 'form-control'])?>
					</div>
					<div class="col-sm-3">
						<?php if ($productCatForm->hasErrors('name')):?>
							<span class="error"><?=Html::error($productCatForm, 'name')?></span>
						<?php endif;?>
					</div>
				</div>
				
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 分类英文名称： </label>
					<div class="col-sm-6">
						<?=Html::textInput('ProductCatForm[en_name]', $productCatForm->en_name, ['class' => 'form-control'])?>
					</div>
					<div class="col-sm-3">
						<?php if ($productCatForm->hasErrors('en_name')):?>
							<span class="error"><?=Html::error($productCatForm, 'en_name')?></span>
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