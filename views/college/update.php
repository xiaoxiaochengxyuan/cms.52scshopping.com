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
			<a href="<?=Yii::$app->urlManager->createUrl('/college')?>">大学管理</a>
		</li>
		<li class="active">修改页面</li>
	</ul>
</div>

<div class="page-content">
	<div class="page-header">
		<h1>
			大学管理
			<small>
				<i class="icon-double-angle-right"></i>
				修改页面
			</small>
		</h1>
	</div><!-- /.page-header -->

	<div class="row">
		<div class="col-xs-12">
			<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal']])?>
				<?=AlertMsgWidget::widget(['view' => $this])?>
				<?=Html::hiddenInput('CollegeForm[id]', $collegeForm->id)?>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 名称： </label>
					<div class="col-sm-6">
						<?=Html::textInput('CollegeForm[name]', $collegeForm->name, ['class' => 'form-control'])?>
					</div>
					<div class="col-sm-3">
						<?php if ($collegeForm->hasErrors('name')):?>
							<span class="block error"><?=Html::error($collegeForm, 'name')?></span>
						<?php endif;?>
					</div>
				</div>
				
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 对应区域： </label>
					<div class="col-sm-6">
						<?=Html::dropDownList('CollegeForm[province_id]', $collegeForm->province_id, $provinces, ['onchange' => 'changeProvince(this);'])?>&nbsp;&nbsp;&nbsp;&nbsp;
						<?=Html::dropDownList('CollegeForm[city_id]', $collegeForm->city_id, $cities, ['id' => 'citySelect', 'onchange' => 'changeCity(this);'])?>&nbsp;&nbsp;&nbsp;&nbsp;
						<?=Html::dropDownList('CollegeForm[region_id]', $collegeForm->region_id, $regions, ['id' => 'regionSelect'])?>
					</div>
					<div class="col-sm-3">
						<?php if ($collegeForm->hasErrors('province_id')):?>
							<span class="block error"><?=Html::error($collegeForm, 'province_id')?></span>
						<?php endif;?>
						<?php if ($collegeForm->hasErrors('city_id')):?>
							<span class="block error"><?=Html::error($collegeForm, 'city_id')?></span>
						<?php endif;?>
						<?php if ($collegeForm->hasErrors('region_id')):?>
							<span class="block error"><?=Html::error($collegeForm, 'region_id')?></span>
						<?php endif;?>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 详细地址： </label>
					<div class="col-sm-6">
						<?=Html::textInput('CollegeForm[detail_address]', $collegeForm->detail_address, ['class' => 'form-control'])?>
					</div>
					<div class="col-sm-3">
						<?php if ($collegeForm->hasErrors('detail_address')):?>
							<span class="block error"><?=Html::error($collegeForm, 'detail_address')?></span>
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


<script>
function changeProvince(obj) {
	var select = $(obj);
	var value = select.val();
	$.get("<?=Yii::$app->urlManager->createUrl('/common/get-regions')?>", {
		'pid' : value
	}, function(response) {
		$("#citySelect").html(response);
		var cityId = $("#citySelect").val();
		$.get("<?=Yii::$app->urlManager->createUrl('/common/get-regions')?>", {
			'pid' : cityId
		}, function(response) {
			$("#regionSelect").html(response);
		});
	});
}


function changeCity(obj) {
	var select = $(obj);
	var value = select.val();
	$.get("<?=Yii::$app->urlManager->createUrl('/common/get-regions')?>", {
		'pid' : value
	}, function(response) {
		$("#regionSelect").html(response);
	});
}
</script>