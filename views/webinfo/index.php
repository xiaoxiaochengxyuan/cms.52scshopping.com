<?php
use yii\widgets\ActiveForm;
use app\widgets\AlertMsgWidget;
use yii\helpers\Html;
?>
<?=$this->render('/includes/kindeditor')?>
<script type="text/javascript">
$(function(){
	KindEditor.ready(function(K) {
		window.editor = K.create('#about_us_areatext', {
			uploadJson : '<?=Yii::$app->urlManager->createUrl('/common/editor-upload-img')?>'
		});
	});
});
</script>
<div class="breadcrumbs" id="breadcrumbs">
	<script type="text/javascript">
		try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
	</script>

	<ul class="breadcrumb">
		<li>
			<i class="icon-home home-icon"></i>
			<a href="<?=Yii::$app->urlManager->createUrl('/webinfo')?>">网站基本信息</a>
		</li>
		<li class="active">编辑网站基本信息</li>
	</ul>
</div>

<div class="page-content">
	<div class="page-header">
		<h1>
			网站基本信息
			<small>
				<i class="icon-double-angle-right"></i>
				编辑网站基本信息
			</small>
		</h1>
	</div>
	
	<div class="row">
		<div class="col-xs-12">
			<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal']])?>
				<?=AlertMsgWidget::widget(['view' => $this])?>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 网站名称： </label>
					<div class="col-sm-6">
						<?=Html::textInput('WebinfoForm[web_name]', $webinfoForm->web_name, ['class' => 'form-control'])?>
					</div>
					<div class="col-sm-3">
						<?php if ($webinfoForm->hasErrors('web_name')):?>
							<span class="block error"><?=Html::error($webinfoForm, 'name')?></span>
						<?php endif;?>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 网站关键字： </label>
					<div class="col-sm-6">
						<?=Html::textInput('WebinfoForm[keywords]', $webinfoForm->keywords, ['class' => 'form-control'])?>
					</div>
					<div class="col-sm-3">
						<?php if ($webinfoForm->hasErrors('keywords')):?>
							<span class="block error"><?=Html::error($webinfoForm, 'keywords')?></span>
						<?php endif;?>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 网站描述： </label>
					<div class="col-sm-6">
						<?=Html::textarea('WebinfoForm[desc]', $webinfoForm->desc, ['class' => 'form-control', 'style' => 'height:150px;'])?>
					</div>
					<div class="col-sm-3">
						<?php if ($webinfoForm->hasErrors('desc')):?>
							<span class="block error"><?=Html::error($webinfoForm, 'desc')?></span>
						<?php endif;?>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 关于我们： </label>
					<div class="col-sm-6">
						<?=Html::textarea('WebinfoForm[about_us]', $webinfoForm->about_us, ['class' => 'form-control', 'id' => 'about_us_areatext', 'style' => 'height:450px;'])?>
					</div>
					<div class="col-sm-3">
						<?php if ($webinfoForm->hasErrors('about_us')):?>
							<span class="block error"><?=Html::error($webinfoForm, 'about_us')?></span>
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