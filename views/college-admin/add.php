<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\widgets\AlertMsgWidget;
?>
<div class="breadcrumbs" id="breadcrumbs">
	<script type="text/javascript">
		try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
	</script>

	<ul class="breadcrumb">
		<li>
			<i class="icon-home home-icon"></i>
			<a href="<?=Yii::$app->urlManager->createUrl('/college')?>">大学管理</a>
		</li>
		<li class="active">添加管理员</li>
	</ul>
</div>

<div class="page-content">
	<div class="page-header">
		<h1>
			大学管理
			<small>
				<i class="icon-double-angle-right"></i>
				添加管理员
			</small>
			<a href="<?=Yii::$app->urlManager->createUrl(['/college-admin', 'college_dorm_area_id' => $collegeAdminForm->college_dorm_area_id])?>" class="btn btn-xs btn-warning" style="float: right;">返回</a>
		</h1>
	</div><!-- /.page-header -->
	<div class="row">
		<div class="col-xs-12">
			<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal']])?>
				<?=AlertMsgWidget::widget(['view' => $this])?>
				<?=Html::hiddenInput('CollegeAdminForm[college_dorm_area_id]', $collegeAdminForm->college_dorm_area_id)?>
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 用户名： </label>
					<div class="col-sm-6">
						<?=Html::textInput('CollegeAdminForm[username]', $collegeAdminForm->username, ['class' => 'form-control'])?>
					</div>
					<div class="col-sm-3">
						<?php if ($collegeAdminForm->hasErrors('username')):?>
							<span class="error"><?=Html::error($collegeAdminForm, 'username')?></span>
						<?php endif;?>
					</div>
				</div>
				
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 手机号： </label>
					<div class="col-sm-6">
						<?=Html::textInput('CollegeAdminForm[phone]', $collegeAdminForm->phone, ['class' => 'form-control'])?>
					</div>
					<div class="col-sm-3">
						<?php if ($collegeAdminForm->hasErrors('phone')):?>
							<span class="error"><?=Html::error($collegeAdminForm, 'phone')?></span>
						<?php endif;?>
					</div>
				</div>
				
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 是否是超级管理员： </label>
					<div class="col-sm-6">
						<?=Html::dropDownList('CollegeAdminForm[is_super]', $collegeAdminForm->is_super, ['否', '是'])?>
					</div>
					<div class="col-sm-3">
						<?php if ($collegeAdminForm->hasErrors('is_super')):?>
							<span class="error"><?=Html::error($collegeAdminForm, 'is_super')?></span>
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