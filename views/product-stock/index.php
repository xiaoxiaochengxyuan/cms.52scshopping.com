<div class="breadcrumbs" id="breadcrumbs">
	<script type="text/javascript">
		try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
	</script>
	
	<ul class="breadcrumb">
		<li>
			<i class="icon-home home-icon"></i>
			<a href="<?=Yii::$app->urlManager->createUrl('/product')?>">商品管理</a>
		</li>
		<li><?=$productName?></li>
		<li class="active">库存列表</li>
	</ul>
</div>

<div class="page-content">
	<div class="page-header">
		<h1>
			商品管理
			<small>
				<i class="icon-double-angle-right"></i>
				<?=$productName?>
			</small>
			<small>
				<i class="icon-double-angle-right"></i>
				库存列表
			</small>
			<a href="<?=Yii::$app->urlManager->createUrl(['/product-stock/add', 'product_id' => $productId])?>" class="btn btn-xs btn-pink" style="float: right;">添加库存</a>
		</h1>
	</div>
</div>