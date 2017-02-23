<?php
use yii\widgets\ActiveForm;
use app\widgets\AlertMsgWidget;
use yii\helpers\Html;
?>
<!-- 引入uploadify -->
<?=$this->render('/includes/uploadify')?>
<?=$this->render('/includes/kindeditor')?>

<script type="text/javascript">
function deleteListImg(obj) {
	$(obj).parent().parent().remove();
}


$(function(){
	$('#title_img').uploadify({
		'swf': '<?=UPLOADIFY_STATIC_URL?>/uploadify.swf',
		'uploader':'<?=Yii::$app->urlManager->createUrl('common/upload-img')?>',
		'fileTypeExts' : '*.gif; *.jpg; *.png',
        'multi': false,
        'method': 'post',
        'buttonText': "选择标题图片",
        'onUploadSuccess': function (file, data, response) {
	        var res = eval('(' + data + ')');
	        var image = "<img alt='标题图片' src='" + res.url + "' style='width:200px;height:200px;'/>";
	        $("#title_img_div").html(image);
	        $("#title_img_input").val(res.fileName);
        },
        'onUploadError' : function(file,errorCode,errorMsg,errorString,swfuploadifyQueue) {
	        alert('上传图片失败');
        },
        'auto': true
	});


	$('#list_imgs').uploadify({
		'swf': '<?=UPLOADIFY_STATIC_URL?>/uploadify.swf',
		'uploader':'<?=Yii::$app->urlManager->createUrl('common/upload-img')?>',
		'fileTypeExts' : '*.gif; *.jpg; *.png',
        'multi': false,
        'method': 'post',
        'buttonText': "选择列表图片",
        'onUploadSuccess': function (file, data, response) {
	        var res = eval('(' + data + ')');
	        var span = "<span style='border:1px solid #aaa; padding:5px;float:left;width:212px;'>" +
	            "<img alt='标题图片' src='" + res.url + "' style='width:200px;height:200px;'/>" +
	            "<input type='hidden' name='ProductForm[list_imgs][]' value='" + res.fileName + "'/>" +
	            "<center><button type='button' style='margin-top:10px;' class='btn btn-xs btn-danger' onclick='deleteListImg(this)'>删除</button></center>" +
	        "</span>";
	        $("#list_img_div").append(span);
        },
        'onUploadError' : function(file,errorCode,errorMsg,errorString,swfuploadifyQueue) {
	        alert('上传图片失败');
        },
        'auto': true
	});


	KindEditor.ready(function(K) {
        window.editor = K.create('#desc_textarea', {
        	uploadJson : '<?=Yii::$app->urlManager->createUrl('/common/editor-upload-img')?>'
        });
    });
});


function changeTopCat(obj) {
	var topCatId = $(obj).val();
	alert(topCatId);
}
</script>
<div class="breadcrumbs" id="breadcrumbs">
	<script type="text/javascript">
		try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
	</script>

	<ul class="breadcrumb">
		<li>
			<i class="icon-home home-icon"></i>
			<a href="<?=Yii::$app->urlManager->createUrl('/product')?>">商品管理</a>
		</li>
		<li class="active">添加商品</li>
	</ul>
</div>

<div class="page-content">
	<div class="page-header">
		<h1>
			商品管理
			<small>
				<i class="icon-double-angle-right"></i>
				添加商品
			</small>
		</h1>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal']])?>
				<?=AlertMsgWidget::widget(['view' => $this])?>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 商品名称： </label>
					<div class="col-sm-6">
						<?=Html::textInput('ProductForm[name]', $productForm->name, ['class' => 'form-control'])?>
					</div>
					<div class="col-sm-3">
						<?php if ($productForm->hasErrors('name')):?>
							<span class="block error"><?=Html::error($productForm, 'name')?></span>
						<?php endif;?>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 商品价格： </label>
					<div class="col-sm-6">
						<?=Html::textInput('ProductForm[price]', $productForm->price, ['class' => 'form-control'])?>
					</div>
					<div class="col-sm-3">
						<?php if ($productForm->hasErrors('price')):?>
							<span class="block error"><?=Html::error($productForm, 'price')?></span>
						<?php endif;?>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 所属分类： </label>
					<div class="col-sm-6">
						<?=Html::dropDownList('ProductForm[top_cat_id]', $productForm->top_cat_id, $topProductCats, ['style' => 'width:100px;', 'onchange' => 'changeTopCat(this)'])?>&nbsp;&nbsp;
						<?=Html::dropDownList('ProductForm[cat_id]', $productForm->cat_id, $productCats, ['style' => 'width:100px;'])?>
					</div>
					<div class="col-sm-3">
						<?php if ($productForm->hasErrors('price')):?>
							<span class="block error"><?=Html::error($productForm, 'price')?></span>
						<?php endif;?>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 初始商品库存： </label>
					<div class="col-sm-6">
						<?=Html::textInput('ProductForm[number]', $productForm->number, ['class' => 'form-control'])?>
					</div>
					<div class="col-sm-3">
						<?php if ($productForm->hasErrors('number')):?>
							<span class="block error"><?=Html::error($productForm, 'number')?></span>
						<?php endif;?>
					</div>
				</div>
				
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 初始显示购买量： </label>
					<div class="col-sm-6">
						<?=Html::textInput('ProductForm[show_buy_number]', $productForm->show_buy_number, ['class' => 'form-control'])?>
					</div>
					<div class="col-sm-3">
						<?php if ($productForm->hasErrors('show_buy_number')):?>
							<span class="block error"><?=Html::error($productForm, 'show_buy_number')?></span>
						<?php endif;?>
					</div>
				</div>
				
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 商品参数（一行一个，键和值用->隔开）： </label>
					<div class="col-sm-6">
						<?=Html::textarea('ProductForm[parameters]', $productForm->parameters, ['class' => 'form-control', 'style' => 'resize:none;height:220px;'])?>
					</div>
					<div class="col-sm-3">
						<?php if ($productForm->hasErrors('parameters')):?>
							<span class="block error"><?=Html::error($productForm, 'parameters')?></span>
						<?php endif;?>
					</div>
				</div>
				
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 产地： </label>
					<div class="col-sm-6">
						<?=Html::textInput('ProductForm[create_place]', $productForm->create_place, ['class' => 'form-control'])?>
					</div>
					<div class="col-sm-3">
						<?php if ($productForm->hasErrors('create_place')):?>
							<span class="block error"><?=Html::error($productForm, 'create_place')?></span>
						<?php endif;?>
					</div>
				</div>
				
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">标题图片： </label>
					<div class="col-sm-6">
						<?=Html::fileInput('title_img', null, ['id' => 'title_img'])?>
						<?=Html::hiddenInput('ProductForm[title_img]', $productForm->title_img, ['id' => 'title_img_input'])?>
					</div>
					<div class="col-sm-3">
						<?php if ($productForm->hasErrors('title_img')):?>
							<span class="block error"><?=Html::error($productForm, 'title_img')?></span>
						<?php endif;?>
					</div>
				</div>
				
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
					<div class="col-sm-6" id="title_img_div">
					</div>
					<div class="col-sm-3">
					</div>
				</div>
				
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">列表图片： </label>
					<div class="col-sm-6" id="list_img_input_div">
						<?=Html::fileInput('list_imgs', null, ['id' => 'list_imgs'])?>
					</div>
					<div class="col-sm-3">
						<?php if ($productForm->hasErrors('list_imgs')):?>
							<span class="block error"><?=Html::error($productForm, 'list_imgs')?></span>
						<?php endif;?>
					</div>
				</div>
				
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
					<div class="col-sm-6" id="list_img_div">
					</div>
					<div class="col-sm-3">
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">商品详情： </label>
					<div class="col-sm-6" id="list_img_input_div">
						<?=Html::textarea('ProductForm[desc]', $productForm->desc, ['id' => 'desc_textarea', 'class' => 'form-control', 'style' => 'height:600px;'])?>
					</div>
					<div class="col-sm-3">
						<?php if ($productForm->hasErrors('desc')):?>
							<span class="block error"><?=Html::error($productForm, 'desc')?></span>
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