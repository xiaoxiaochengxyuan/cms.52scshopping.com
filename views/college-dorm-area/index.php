<script type="text/javascript">
//初始化大学区域商品
function initProduct(collegeDormAreaId) {
	if(confirm("您真的要初始化该大学区域商品吗？")) {
		$.get("<?=Yii::$app->getUrlManager()->createUrl(['/college-dorm-area/init-product'])?>", {
			"collegeDormAreaId" : collegeDormAreaId
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
			<a href="<?=Yii::$app->urlManager->createUrl('/college')?>">大学管理</a>
		</li>
		<li class="active"><?=$college['name']?></li>
		<li class="active">列表页面</li>
	</ul>
</div>

<div class="page-content">
	<div class="page-header">
		<h1>
			大学管理
			<small>
				<i class="icon-double-angle-right"></i>
				<?=$college['name']?>
			</small>
			<small>
				<i class="icon-double-angle-right"></i>
				大学宿舍区域列表
			</small>
			<a href="<?=Yii::$app->urlManager->createUrl(['/college-dorm-area/add', 'college_id' => $college['id']])?>" class="btn btn-xs btn-pink" style="float: right;">添加</a>
		</h1>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<table id="sample-table-1" class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th>Id</th>
						<th>大学名称</th>
						<th>大学区域名称</th>
						<th>创建时间</th>
						<th>修改时间</th>
						<th>操作</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($collegeDormAreas as $collegeDormArea):?>
						<tr>
							<td><?=$collegeDormArea['id']?></td>
							<td><?=$collegeDormArea['college_name']?></td>
							<td><?=$collegeDormArea['name']?></td>
							<td><?=date('Y-m-d H:i:s', $collegeDormArea['create_time'])?></td>
							<td><?=date('Y-m-d H:i:s', $collegeDormArea['update_time'])?></td>
							<td>
								<a href="<?=Yii::$app->getUrlManager()->createUrl(['/college-admin', 'college_dorm_area_id' => $collegeDormArea['id']])?>" class="btn btn-xs btn-info">设置大学管理员</a>
								<button class="btn btn-xs btn-success" onclick="initProduct(<?=$collegeDormArea['id']?>)">初始化区域商品</button>
							</td>
						</tr>
					<?php endforeach;?>
				</tbody>
			</table>
		</div>
	</div>
</div>