<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\widgets\AlertMsgWidget;
use yii\base\Widget;
?>
<div class="breadcrumbs" id="breadcrumbs">
	<script type="text/javascript">
		try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
	</script>

	<ul class="breadcrumb">
		<li>
			<i class="icon-home home-icon"></i>
			<a href="<?=Yii::$app->urlManager->createUrl('/')?>">首页</a>
		</li>
		<li class="active">修改密码</li>
	</ul>
</div>


<div class="page-content">
	<div class="page-header">
		<h1>
			首页
			<small>
				<i class="icon-double-angle-right"></i>
				修改密码
			</small>
		</h1>
	</div><!-- /.page-header -->

	<div class="row">
		<div class="col-xs-12">
			<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal']])?>
				<?=AlertMsgWidget::widget(['view' => $this])?>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 旧密码： </label>
					<div class="col-sm-6">
						<?=Html::passwordInput('CmsAdminForm[oldPassword]', $cmsAdminForm->oldPassword, ['placeholder' => '旧密码', 'class' => 'form-control'])?>
					</div>
					<div class="col-sm-3">
						<?php if ($cmsAdminForm->hasErrors('oldPassword')):?>
							<span class="block error"><?=Html::error($cmsAdminForm, 'oldPassword')?></span>
						<?php endif;?>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 新密码： </label>
					<div class="col-sm-6">
						<?=Html::passwordInput('CmsAdminForm[password]', $cmsAdminForm->password, ['placeholder' => '新密码', 'class' => 'form-control'])?>
					</div>
					<div class="col-sm-3">
						<?php if ($cmsAdminForm->hasErrors('password')):?>
							<span class="block error"><?=Html::error($cmsAdminForm, 'password')?></span>
						<?php endif;?>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 重复密码： </label>
					<div class="col-sm-6">
						<?=Html::passwordInput('CmsAdminForm[rePassword]', $cmsAdminForm->rePassword, ['placeholder' => '重复密码', 'class' => 'form-control'])?>
					</div>
					<div class="col-sm-3">
						<?php if ($cmsAdminForm->hasErrors('rePassword')):?>
							<span class="block error"><?=Html::error($cmsAdminForm, 'rePassword')?></span>
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