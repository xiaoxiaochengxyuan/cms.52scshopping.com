<?php
use yii\widgets\LinkPager;
?>
<script type="text/javascript">
function chgEnable(id, text) {
	if(confirm("请问您是否要将该消息设置为" + text + "呢？")) {
		$.get("<?=Yii::$app->getUrlManager()->createUrl(['/message/chg-enable'])?>", {
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
			<a href="<?=Yii::$app->urlManager->createUrl('/message')?>">消息管理</a>
		</li>
		<li class="active">消息列表</li>
	</ul>
</div>

<div class="page-content">
	<div class="page-header">
		<h1>
			消息管理
			<small>
				<i class="icon-double-angle-right"></i>
				消息列表
			</small>
			<a href="<?=Yii::$app->urlManager->createUrl(['/message/add'])?>" class="btn btn-xs btn-pink" style="float: right;">添加消息</a>
		</h1>
	</div>
	
	<div class="row">
		<div class="col-xs-12">
			<table id="sample-table-1" class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th>ID</th>
						<th>标题</th>
						<th>是否可用</th>
						<th>简介</th>
						<th>关键字</th>
						<th>所在大学</th>
						<th>操作</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($messages as $message):?>
						<tr>
							<td><?=$message['id']?></td>
							<td><?=$message['title']?></td>
							<td><?=$message['enable'] == 1 ? '<font color="green">是</font>' : '<font color="red">否</font>'?></td>
							<td><?=$message['desc']?></td>
							<td><?=$message['keywords']?></td>
							<td><?=empty($message['college_name']) ? '<font color="blue">系统消息</font>' : '<font color="#DA4453">'.$message['college_name'].'</font>'?></td>
							<td>
								<?php if ($message['enable'] == 0):?>
									<button class="btn btn-success btn-xs" onclick="chgEnable(<?=$message['id']?>, '可用')">设为可用</button>
								<?php else:?>
									<button class="btn btn-danger btn-xs" onclick="chgEnable(<?=$message['id']?>, '可用')">设为不可用</button>
								<?php endif;?>
								<a href="<?=Yii::$app->getUrlManager()->createUrl(['/message/update', 'id' => $message['id']])?>" class="btn btn-info btn-xs">修改</a>
							</td>
						</tr>
					<?php endforeach;?>
				</tbody>
			</table>
			<center><?=LinkPager::widget(['pagination' => $pagination,]);?></center>
		</div>
</div>