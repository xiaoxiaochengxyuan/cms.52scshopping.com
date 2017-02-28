<?php
namespace app\filters;
use yii\base\ActionFilter;
use app\daos\CmsAdmin;
/**
 * 权限先关的过滤器
 * @author xiawei
 */
class AuthFilter extends ActionFilter {
	/**
	 * {@inheritDoc}
	 * @see \yii\base\ActionFilter::beforeAction()
	 */
	public function beforeAction($action) {
		$actionId = $action->id;
		$controllerId = $action->controller->id;
		$auth = \Yii::$app->params['auth'];
		//如果需要权限验证
		if (isset($auth[$controllerId]) && (isset($auth[$controllerId]['*']) || isset($auth[$controllerId][$actionId]))) {
			$level = isset($auth[$controllerId]['*']) ? $auth[$controllerId]['*'] : $auth[$controllerId][$actionId];
			$currentLoginLevel = CmsAdmin::loginInfo('level');
			if ($level != $currentLoginLevel) {
				return !parent::beforeAction($action);
			}
		}
		return parent::beforeAction($action);
	}
}