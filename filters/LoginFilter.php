<?php
namespace app\filters;
use yii\base\ActionFilter;
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
		return parent::beforeAction($action);
	}
}