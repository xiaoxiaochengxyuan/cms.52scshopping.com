<script type="text/javascript">
function deleteProductStock(id) {
	if(confirm("您真的要删除这个商品吗？")) {
		$.get("<?=Yii::$app->getUrlManager()->createUrl('/product-stock/delete')?>",{
			'id' : id
		}, function(response){
			if(response.code == <?=ERROR_CODE_NONE?>) {
				window.location.reload();
			} else {
				alert(response.msg);
			}
		});
	}
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
	<div class="row">
		<div class="col-xs-12">
			<table id="sample-table-1" class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th>ID</th>
						<th>库存名称</th>
						<th>初始化数量</th>
						<th>警告数量</th>
						<th>进货价格</th>
						<th>价格</th>
						<th>对应商品名称</th>
						<th>操作</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($productStocks as $productStock):?>
						<tr>
							<td><?=$productStock['id']?></td>
							<td><?=$productStock['name']?></td>
							<td><?=$productStock['num']?></td>
							<td><?=$productStock['warning_num']?></td>
							<td><?=$productStock['stock_price']?></td>
							<td><?=$productStock['price']?></td>
							<td><?=$productStock['product_name']?></td>
							<td>
								<a href="<?=Yii::$app->getUrlManager()->createUrl(['/product-stock/update', 'id' => $productStock['id']])?>" class="btn btn-xs btn-info">修改</a>
								<button class="btn btn-xs btn-danger" onclick="deleteProductStock(<?=$productStock['id']?>)">删除</button>
							</td>
						</tr>
					<?php endforeach;?>
				</tbody>
			</table>
		</div>
	</div>
</div>