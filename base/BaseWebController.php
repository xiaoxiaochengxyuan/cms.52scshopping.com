<?php
namespace app\base;
use yii\web\Controller;
/**
 * 所以Controller的基类
 * @author xiawei
 */
abstract class BaseWebController extends Controller {
	/**
	 * {@inheritDoc}
	 * @see \yii\base\Component::behaviors()
	 */
	public function behaviors():array {
		return [[
			'class' => 'app\filters\LoginFilter',
		]];
	}
	
	/**
	 * {@inheritDoc}
	 * @see \yii\base\Controller::renderPartial()
	 */
	public function renderPartial($view, $params = []) {
		$this->defineStatic();
		return parent::renderPartial($view, $params);
	}
	
	/**
	 * {@inheritDoc}
	 * @see \yii\base\Controller::render()
	 */
	public function render($view, $params = []) {
		$this->defineStatic();
		return parent::render($view, $params);
	}
	
	/**
	 * 定义一些在模板中需要使用的常量
	 */
	private function defineStatic() : void {
		defined('ACE_STATIC_URL') or define('ACE_STATIC_URL', \Yii::$app->urlManager->baseUrl.'/static/ace');
		defined('ACE_STATIC_JS_URL') or define('ACE_STATIC_JS_URL', ACE_STATIC_URL.'/js');
		defined('ACE_STATIC_CSS_URL') or define('ACE_STATIC_CSS_URL', ACE_STATIC_URL.'/css');
	}
}