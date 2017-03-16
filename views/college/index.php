<?php
use yii\widgets\LinkPager;
?>
<script type="text/javascript">
function initCollegeProduct(collegeId) {
	if(confirm("您真的要初始化该大学的产品吗？")) {
		$.get("<?=Yii::$app->getUrlManager()->createUrl(['/college/init-product'])?>", {
			'collegeId' : collegeId
		}, function(response) {
			if(response.code != <?=ERROR_CODE_NONE?>) {
				alert(response.msg);
			} else {
				window.location.reload();
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
		<li class="active">列表页面</li>
	</ul>
</div>

<div class="page-content">
	<div class="page-header">
		<h1>
			大学管理
			<small>
				<i class="icon-double-angle-right"></i>
				列表页面
			</small>
			<a href="<?=Yii::$app->urlManager->createUrl(['/college/add'])?>" class="btn btn-xs btn-pink" style="float: right;">添加</a>
		</h1>
	</div><!-- /.page-header -->

	<div class="row">
		<div class="col-xs-12">
			<table id="sample-table-1" class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th>Id</th>
						<th>名称</th>
						<th>地址</th>
						<th>操作</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($colleges as $college):?>
						<tr>
							<td><?=$college['id']?></td>
							<td><?=$college['name']?></td>
							<td><?=$college['province_name']?>、<?=$college['city_name']?>、<?=$college['region_name']?>、<?=$college['detail_address']?></td>
							<td>
								<a href="<?=Yii::$app->getUrlManager()->createUrl(['/college/update', 'id' => $college['id']])?>" class="btn btn-xs btn-info">修改</a>
								<a href="<?=Yii::$app->getUrlManager()->createUrl(['/college-dorm-area', 'college_id' => $college['id']])?>" class="btn btn-xs btn-warning">寝室区域管理</a>
							</td>
						</tr>
					<?php endforeach;?>
				</tbody>
			</table>
			<center><?=LinkPager::widget(['pagination' => $pagination,]);?></center>
		</div>
	</div>
</div>