<?php
use app\utils\OssUtil;
?>
<div class="breadcrumbs" id="breadcrumbs">
	<script type="text/javascript">
		try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
	</script>

	<ul class="breadcrumb">
		<li>
			<i class="icon-home home-icon"></i>
			<a href="<?=Yii::$app->urlManager->createUrl('/product-cat')?>">商品类型管理</a>
		</li>
		<li class="active">类型列表</li>
	</ul>
</div>

<div class="page-content">
	<div class="page-header">
		<h1>
			商品类型管理
			<small>
				<i class="icon-double-angle-right"></i>
				类型列表
			</small>
			<a href="<?=Yii::$app->urlManager->createUrl(['/product-cat/add', 'pid' => $pid])?>" class="btn btn-xs btn-pink" style="float: right;">
				<?php if ($pid == 0):?>
					添加顶级分类
				<?php else :?>
					添加分类
				<?php endif;?>
			</a>
		</h1>
	</div>

	<div class="row">
		<div class="col-xs-12">
			<table id="sample-table-1" class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th>Id</th>
						<th>名称</th>
						<th>英文名称</th>
						<th>父亲栏目名称</th>
						<?php if ($pid == 0):?>
							<th>分类图标</th>
						<?php endif;?>
						<th>操作</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($productCats as $productCat):?>
						<tr>
							<td><?=$productCat['id']?></td>
							<td><?=$productCat['name']?></td>
							<td><?=$productCat['en_name']?></td>
							<td><?=$productCat['ppc_name']?></td>
							<?php if ($pid == 0):?>
								<td><img alt="商品小图标" src="<?=OssUtil::getOssImg($productCat['icon'])?>" style="width: 80px;background: #<?=$productCat['icon_bgcolor']?>;border-radius: 40px;"/></td>
							<?php endif;?>
							<td>
								<button class="btn btn-xs btn-danger" onclick="deleteProductCat(<?=$productCat['id']?>)">删除</button>
								<?php if ($pid == 0):?>
									<a href="<?=Yii::$app->urlManager->createUrl(['/product-cat', 'pid' => $productCat['id']])?>" class="btn btn-xs btn-info">子栏目列表</a>
								<?php endif;?>
								<a href="<?=Yii::$app->urlManager->createUrl(['/product-cat/update', 'id' => $productCat['id']])?>" class="btn btn-xs btn-success">修改</a>
							</td>
						</tr>
					<?php endforeach;?>
				</tbody>
			</table>
		</div>
	</div>
</div>


<script>
function deleteProductCat(id) {
	if(confirm("您确定要删除这个分类吗？（删除之后数据不可恢复）")) {
		$.get("<?=Yii::$app->urlManager->createUrl(['/product-cat/delete'])?>", {
			"id" : id
		}, function(response) {
			if(response.code == <?=ERROR_CODE_NONE?>) {
				window.location.reload();
			} else {
				alert(response.msg);
			}
		});
	}
}
</script>