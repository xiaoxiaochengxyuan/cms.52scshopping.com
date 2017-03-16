<?php
use app\daos\CmsAdmin;

global $currentControllerId,$currentActionId;
$currentControllerId = $controllerId;
$currentActionId = $actionId;
function activeLi($controllerId, $actionId = null) {
	global $currentControllerId,$currentActionId;
	if (is_string($controllerId)) {
		if ($controllerId == $currentControllerId) {
			if (!empty($actionId)) {
				if ($actionId != $currentActionId) {
					return '';
				}
			}
			return 'class="active"';
		}
	} elseif (is_array($controllerId)) {
		foreach ($controllerId as $cid) {
			if ($cid == $currentControllerId) {
				if (!empty($actionId)) {
					if ($actionId != $currentActionId) {
						return '';
					}
				}
				return 'class="active"';
			}
		}
	}
	return '';
}
?>
<ul class="nav nav-list">
	<li <?=activeLi('index')?>>
		<a href="<?=Yii::$app->urlManager->createUrl('/')?>">
			<i class="icon-dashboard"></i>
			<span class="menu-text"> 欢迎页面 </span>
		</a>
	</li>
	
	<?php if (CmsAdmin::hasPremiss('college', 'index')):?>
		<li <?=activeLi(['college', 'college-dorm-area', 'college-admin'])?>>
			<a href="<?=Yii::$app->urlManager->createUrl('/college')?>">
				<i class="icon-bookmark"></i>
				<span class="menu-text"> 学校管理 </span>
			</a>
		</li>
	<?php endif;?>
	
	<?php if (CmsAdmin::hasPremiss('product-cat', 'index')):?>
		<li <?=activeLi('product-cat')?>>
			<a href="<?=Yii::$app->urlManager->createUrl('/product-cat')?>">
				<i class="icon-bar-chart"></i>
				<span class="menu-text"> 商品类型管理 </span>
			</a>
		</li>
	<?php endif;?>
	
	<?php if (CmsAdmin::hasPremiss('product', 'index')):?>
		<li <?=activeLi(['product', 'product-stock'])?>>
			<a href="<?=Yii::$app->urlManager->createUrl('/product')?>">
				<i class="icon-gift"></i>
				<span class="menu-text"> 商品管理 </span>
			</a>
		</li>
	<?php endif;?>
	
	<?php if (CmsAdmin::hasPremiss('webinfo', 'index')):?>
		<li <?=activeLi('webinfo')?>>
			<a href="<?=Yii::$app->urlManager->createUrl('/webinfo')?>">
				<i class="icon-heart"></i>
				<span class="menu-text"> 网站基本信息 </span>
			</a>
		</li>
	<?php endif;?>
	
	
	<?php if (CmsAdmin::hasPremiss('message', 'index')):?>
		<li <?=activeLi('message')?>>
			<a href="<?=Yii::$app->urlManager->createUrl('/message')?>">
				<i class="icon-envelope-alt"></i>
				<span class="menu-text"> 消息列表 </span>
			</a>
		</li>
	<?php endif;?>
</ul>