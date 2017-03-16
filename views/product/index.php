<?php
use yii\helpers\Html;
use app\utils\OssUtil;
use yii\widgets\LinkPager;
use yii\widgets\ActiveForm;
?>

<script type="text/javascript">
function changeGrounding(id, opStr) {
	if(confirm("您真的要" + opStr + "该产品吗？")) {
		$.get("<?=Yii::$app->urlManager->createUrl('/product/chg-grounding')?>", {
			'id' : id
		}, function(response) {
			if(response.code == <?=ERROR_CODE_NONE?>) {
				window.location.reload();
			} else {
				alert(response.msg);
			}
		});
	}
}


function changeTopCatId(obj) {
	var topCatId = $(obj).val();
	$.get("<?=Yii::$app->urlManager->createUrl("/product-cat/second-cat-drop-list")?>", {
		'pid' : topCatId
	}, function(response) {
		response = "<option value='0'>--请选择--</option>" + response;
		$("#catIdSelect").html(response);
	});
}


function deleteProduct(id, productName) {
	if(confirm("请问您真的要删除产品“" + productName + "”吗？删除之后数据不可恢复")) {
		$.get("<?=Yii::$app->getUrlManager()->createUrl(['/product/delete'])?>", {
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

<div class="breadcrumbs" id="breadcrumbs">
	<script type="text/javascript">
		try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
	</script>
	
	<ul class="breadcrumb">
		<li>
			<i class="icon-home home-icon"></i>
			<a href="<?=Yii::$app->urlManager->createUrl('/product')?>">商品管理</a>
		</li>
		<li class="active">商品列表</li>
	</ul>
</div>

<div class="page-content">
	<div class="page-header">
		<h1>
			商品管理
			<small>
				<i class="icon-double-angle-right"></i>
				商品列表
			</small>
			<a href="<?=Yii::$app->urlManager->createUrl(['/product/add'])?>" class="btn btn-xs btn-pink" style="float: right;">添加商品</a>
		</h1>
	</div>
	
	<div class="page-header">
		<?php $form=ActiveForm::begin(['method' => 'get'])?>
			名称：<?=Html::textInput('search[name]', $search['name'])?>&nbsp;
			是否上架：<?=Html::dropDownList('search[grounding]', $search['grounding'], [-1 => '--请选择--', '否', '是'])?>&nbsp;
			进价范围：<?=Html::textInput('search[stock_price_min]', $search['stock_price_min'], ['style' => 'width:70px;'])?> - <?=Html::textInput('search[stock_price_max]', $search['stock_price_max'], ['style' => 'width:70px;'])?>&nbsp;
			对应分类：<?=Html::dropDownList('search[top_cat_id]', $search['top_cat_id'], $topProductCats, ['onchange' => 'changeTopCatId(this)'])?>
					 <?=Html::dropDownList('search[cat_id]', $search['cat_id'], $productCats, ['id' => 'catIdSelect'])?>&nbsp;
					 <button class="btn btn-xs btn-success" type="submit">搜索</button>
		<?php ActiveForm::end()?>
	</div>
	
	
	<div class="row">
		<div class="col-xs-12">
			<table id="sample-table-1" class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th>Id</th>
						<th>名称</th>
						<th>进价</th>
						<th>卖价</th>
						<th>是否上架</th>
						<th>初始显示购买人数</th>
						<th>标题图片</th>
						<th>对应顶级分类</th>
						<th>对应分类</th>
						<th>操作</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($products as $product):?>
						<tr>
							<td><?=$product['id']?></td>
							<td><?=$product['name']?></td>
							<td><?=$product['stock_price']?>元</td>
							<td><?=$product['price']?>元</td>
							<td><?=$product['grounding'] == 1 ? '是' : '否'?></td>
							<td><?=$product['show_buy_number']?></td>
							<td><?=Html::img(OssUtil::getOssImg($product['title_img']), ['style' => 'width:150px;'])?></td>
							<td><?=$product['tpc_name']?></td>
							<td><?=$product['pc_name']?></td>
							<td>
								<button class="btn <?=$product['grounding'] == 1 ? 'btn-warning' : 'btn-success'?> btn-xs" onclick="changeGrounding(<?=$product['id']?>, '<?=$product['grounding'] == 1 ? '下架' : '上架'?>')">
									<?=$product['grounding'] == 1 ? '下架' : '上架'?>
								</button>
								<a href="<?=Yii::$app->getUrlManager()->createUrl(['/product/update', 'id' => $product['id']])?>" class="btn btn-xs btn-info">修改</a>
								<button class="btn btn-xs btn-danger" onclick="deleteProduct(<?=$product['id']?>, '<?=$product['name']?>')">删除</button>
								<a target="_blank" href="http://<?=Yii::$app->params['mobile_domin']?>/product/<?=$product['id']?>/preview.html" class="btn btn-xs btn-warning">浏览</a>
								<a href="<?=Yii::$app->getUrlManager()->createUrl(['/product-stock', 'product_id' => $product['id']])?>" class="btn btn-xs btn-purple">库存管理</a>
							</td>
						</tr>
					<?php endforeach;?>
				</tbody>
			</table>
			<center><?=LinkPager::widget(['pagination' => $pagination,]);?></center>
		</div>
	</div>
</div>