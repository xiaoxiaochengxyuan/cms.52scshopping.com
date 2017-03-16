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
			<a href="<?=Yii::$app->urlManager->createUrl(['/college-dorm-area', 'college_id' => $collegeDormAreaForm->college_id])?>">大学区域管理</a>
		</li>
		<li class="active">添加大学宿舍区域</li>
	</ul>
</div>

<div class="page-content">
	<div class="page-header">
		<h1>
			大学区域管理
			<small>
				<i class="icon-double-angle-right"></i>
				添加大学宿舍区域
			</small>
			<a href="<?=Yii::$app->urlManager->createUrl(['/college-dorm-area', 'college_id' => $collegeDormAreaForm->college_id])?>" class="btn btn-xs btn-inverse" style="float: right;">返回</a>
		</h1>
	</div>
	
	<div class="row">
		<div class="col-xs-12">
			<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal']])?>
				<?=AlertMsgWidget::widget(['view' => $this])?>
				<?=Html::hiddenInput('CollegeDormAreaForm[college_id]', $collegeDormAreaForm->college_id)?>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 名称： </label>
					<div class="col-sm-6">
						<?=Html::textInput('CollegeDormAreaForm[name]', $collegeDormAreaForm->name, ['class' => 'form-control'])?>
					</div>
					<div class="col-sm-3">
						<?php if ($collegeDormAreaForm->hasErrors('name')):?>
							<span class="block error"><?=Html::error($collegeDormAreaForm, 'name')?></span>
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