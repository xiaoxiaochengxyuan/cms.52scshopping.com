<?php
namespace app\filters;
use yii\base\ActionFilter;
use app\daos\CmsAdmin;
/**
 * 检查用户登录的过滤器
 * @author xiawei
 */
class LoginFilter extends ActionFilter {
	/**
	 * {@inheritDoc}
	 * @see \yii\base\ActionFilter::beforeAction()
	 */
	public function beforeAction($action) {
		$actionId = $action->id;
		$controllerId = $action->controller->id;
		$noLogin = \Yii::$app->params['noLogin'];
		if ((isset($noLogin[$controllerId]) && ($noLogin[$controllerId] == '*' || in_array($actionId, $noLogin[$controllerId]))) || CmsAdmin::isLogin()) {
			return parent::beforeAction($action);
		}
		\Yii::$app->response->redirect(['/login']);
		return !parent::beforeAction($action);
	}
}