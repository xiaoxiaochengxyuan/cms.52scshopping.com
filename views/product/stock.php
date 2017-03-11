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
		<li class="active">库存管理</li>
	</ul>
</div>

<div class="page-content">
	<div class="page-header">
		<h1>
			商品管理
			<small>
				<i class="icon-double-angle-right"></i>
				库存管理
			</small>
		</h1>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal']])?>
				<?=AlertMsgWidget::widget(['view' => $this])?>
				<?php foreach ($productStocks as $productStock):?>
					<div class="form-group">
						<label class="col-sm-4 control-label no-padding-right" for="form-field-1"><?=$productStock['options']?>（<?=$productStock['num']?>件）：</label>
						<div class="col-sm-4">
							增加&nbsp;<?=Html::textInput('ProductStock['.$productStock['id'].']', 0, ['class' => 'form-control', 'style' => 'display:inline;width:80%;'])?>&nbsp;件
						</div>
						<div class="col-sm-4">
							<?php if (isset($errors[$productStock['id']])):?>
								<span class="block error"><?=$errors[$productStock['id']]?></span>
							<?php endif;?>
						</div>
					</div>
				<?php endforeach;?>
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