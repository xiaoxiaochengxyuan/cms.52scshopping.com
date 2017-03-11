<?php
use yii\widgets\ActiveForm;
use app\widgets\AlertMsgWidget;
use yii\helpers\Html;
use app\utils\OssUtil;
?>
<!-- 引入uploadify -->
<?=$this->render('/includes/uploadify')?>
<!-- 引入simple-color -->
<?=$this->render('/includes/js-color')?>

<script type="text/javascript">
$(function(){
	$('#iconInput').uploadify({
		'swf': '<?=UPLOADIFY_STATIC_URL?>/uploadify.swf',
		'uploader':'<?=Yii::$app->urlManager->createUrl('common/upload-img')?>',
		'fileTypeExts' : '*.gif; *.jpg; *.png',
        'multi': false,
        'method': 'post',
        'buttonText': "选择图标",
        'onUploadSuccess': function (file, data, response) {
        	var res = eval('(' + data + ')');
            var iconImg = "<img src='" + res.url + "' style='border-radius: 40px;width:80px;background:#" + $('#icon_bgcolor_id').val() + ";' id='icon_image_ele'/>";
            $("#iconDiv").html(iconImg);
            $("#iconHiddenInput").val(res.fileName);
        },
        'onUploadError' : function(file,errorCode,errorMsg,errorString,swfuploadifyQueue) {
	        alert('上传图标');
        },
        'auto': true
	});
});

function setTextColor(picker) {
	var color = picker.toString();
	$("#icon_image_ele").css('background', '#' + color);
	$("#icon_bgcolor_id").val(color);
}
</script>
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
				<?=Html::hiddenInput('ProductCatForm[id]', $productCatForm->id)?>
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
				
				
				<?php if ($productCatForm->pid == 0):?>
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 分类图标背景颜色： </label>
						<div class="col-sm-6">
							<?=Html::textInput(
								'ProductCatForm[icon_bgcolor]',
								$productCatForm->icon_bgcolor,
								[
									'id' => 'icon_bgcolor_id',
									'class' => 'jscolor {onFineChange:"setTextColor(this)"}',
								]
							)?>
						</div>
						<div class="col-sm-3">
							<?php if ($productCatForm->hasErrors('icon_bgcolor')):?>
								<span class="error"><?=Html::error($productCatForm, 'icon_bgcolor')?></span>
							<?php endif;?>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 分类小图标： </label>
						<div class="col-sm-6">
							<?=Html::fileInput('icon', null, ['id' => 'iconInput'])?>
							<?=Html::hiddenInput('ProductCatForm[icon]', $productCatForm->icon, ['id' => 'iconHiddenInput'])?>
						</div>
						<div class="col-sm-3">
							<?php if ($productCatForm->hasErrors('icon')):?>
								<span class="error"><?=Html::error($productCatForm, 'icon')?></span>
							<?php endif;?>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
						<div class="col-sm-6" id="iconDiv">
							<?php if (!empty($productCatForm->icon_bgcolor) && !empty($productCatForm->icon)):?>
								<img src='<?=OssUtil::getOssImg($productCatForm->icon)?>' style='border-radius: 40px;width:80px;background:#<?=$productCatForm->icon_bgcolor?>;' id='icon_image_ele'/>
							<?php endif;?>
						</div>
						<div class="col-sm-3">
						</div>
					</div>
					<br/>
					<br/>
				<?php endif;?>
				
				
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