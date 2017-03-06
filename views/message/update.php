<?php
use yii\widgets\ActiveForm;
use app\widgets\AlertMsgWidget;
use app\widgets\ErrorTipWidget;
use yii\helpers\Html;
?>
<!-- 引入kindeditor -->
<?=$this->render('/includes/kindeditor')?>
<script type="text/javascript">
$(function(){
	KindEditor.ready(function(K) {
        window.editor = K.create('#content', {
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
			<a href="<?=Yii::$app->urlManager->createUrl('/message')?>">消息管理</a>
		</li>
		<li class="active">修改消息</li>
	</ul>
</div>

<div class="page-content">
	<div class="page-header">
		<h1>
			消息管理
			<small>
				<i class="icon-double-angle-right"></i>
				修改消息
			</small>
		</h1>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal']])?>
				<?=AlertMsgWidget::widget(['view' => $this])?>
				<?=Html::hiddenInput('MessageForm[id]', $messageForm->id)?>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 标题： </label>
					<div class="col-sm-6">
						<?=Html::textInput('MessageForm[title]', $messageForm->title, ['class' => 'form-control', 'placeholder' => '标题'])?>
					</div>
					<div class="col-sm-3">
						<?=ErrorTipWidget::widget(['form' => $messageForm, 'attribute' => 'title'])?>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 关键字： </label>
					<div class="col-sm-6">
						<?=Html::textInput('MessageForm[keywords]', $messageForm->keywords, ['class' => 'form-control', 'placeholder' => '关键字'])?>
					</div>
					<div class="col-sm-3">
						<?=ErrorTipWidget::widget(['form' => $messageForm, 'attribute' => 'keywords'])?>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 描述： </label>
					<div class="col-sm-6">
						<?=Html::textarea('MessageForm[desc]', $messageForm->desc, ['class' => 'form-control', 'placeholder' => '描述', 'style' => 'height:150px;'])?>
					</div>
					<div class="col-sm-3">
						<?=ErrorTipWidget::widget(['form' => $messageForm, 'attribute' => 'desc'])?>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">消息内容： </label>
					<div class="col-sm-6" id="list_img_input_div">
						<?=Html::textarea('MessageForm[content]', $messageForm->content, ['id' => 'content', 'class' => 'form-control', 'style' => 'height:600px;'])?>
					</div>
					<div class="col-sm-3">
						<?=ErrorTipWidget::widget(['form' => $messageForm, 'attribute' => 'content'])?>
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