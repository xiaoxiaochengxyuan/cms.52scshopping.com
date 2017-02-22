<?php
use yii\widgets\LinkPager;
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
		<li class="active">管理员列表</li>
	</ul>
</div>

<div class="page-content">
	<div class="page-header">
		<h1>
			大学管理
			<small>
				<i class="icon-double-angle-right"></i>
				管理员列表
			</small>
			<a href="<?=Yii::$app->urlManager->createUrl(['/college-admin/add', 'college_id' => $college_id])?>" class="btn btn-xs btn-pink" style="float: right;">添加</a>
		</h1>
	</div><!-- /.page-header -->

	<div class="row">
		<div class="col-xs-12">
			<table id="sample-table-1" class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th>Id</th>
						<th>用户名</th>
						<th>电话号码</th>
						<th>操作</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($collegeAdmins as $collegeAdmin):?>
						<tr>
							<td><?=$collegeAdmin['id']?></td>
							<td><?=$collegeAdmin['username']?></td>
							<td><?=$collegeAdmin['phone']?></td>
							<td>
								<button class="btn btn-xs btn-danger" onclick="deleteCollegeAdmin(<?=$collegeAdmin['id']?>)">删除</button>&nbsp;&nbsp;
								<button class="btn btn-xs btn-info" onclick="resetPassword(<?=$collegeAdmin['id']?>)">重置密码</button>&nbsp;&nbsp;
								<a href="<?=Yii::$app->urlManager->createUrl(['/college-admin/update', 'id' => $collegeAdmin['id']])?>" class="btn btn-xs btn-success">修改</a>
							</td>
						</tr>
					<?php endforeach;?>
				</tbody>
			</table>
			<center><?=LinkPager::widget(['pagination' => $pagination,]);?></center>
		</div>
	</div>
</div>


<script>
function deleteCollegeAdmin(id) {
	if(confirm('请问您真的删除该管理员吗？')) {
		$.get("<?=Yii::$app->urlManager->createUrl('/college-admin/delete')?>", {
			'id' : id
		}, function(response) {
			window.location.reload();
		});
	}
}


function resetPassword(id) {
	if(confirm('请问您真的要重置密码吗？')) {
		$.get("<?=Yii::$app->urlManager->createUrl('/college-admin/reset-password')?>", {
			'id' : id
		}, function(response) {
			window.location.reload();
		});
	}
}
</script>