<?php
use app\daos\CmsAdmin;

global $currentControllerId,$currentActionId;
$currentControllerId = $controllerId;
$currentActionId = $actionId;
function activeLi(string $controllerId, string $actionId = null) : string{
	global $currentControllerId,$currentActionId;
	if ($controllerId == $currentControllerId) {
		if (!empty($actionId)) {
			if ($actionId != $currentActionId) {
				return '';
			}
		}
		return 'class="active"';
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
		<li <?=activeLi('college')?>>
			<a href="<?=Yii::$app->urlManager->createUrl('/college')?>">
				<i class="icon-bookmark"></i>
				<span class="menu-text"> 学校管理 </span>
			</a>
		</li>
	<?php endif;?>
</ul>