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
		defined('STATIC_URL') or define('STATIC_URL', \Yii::$app->urlManager->baseUrl.'/static');
		defined('ACE_STATIC_URL') or define('ACE_STATIC_URL', STATIC_URL.'/ace');
		defined('ACE_STATIC_JS_URL') or define('ACE_STATIC_JS_URL', ACE_STATIC_URL.'/js');
		defined('ACE_STATIC_CSS_URL') or define('ACE_STATIC_CSS_URL', ACE_STATIC_URL.'/css');
		defined('ACE_STATIC_AVATOR_URL') or define('ACE_STATIC_AVATOR_URL', ACE_STATIC_URL.'/avatars');
	}
	
	/**
	 * 添加成功信息
	 * @param string $msg 成功信息
	 */
	protected function addSuccMsg(string $msg) : void {
		if (empty($this->view->params['succ'])) {
			$this->view->params['succ'] = [];
		}
		$this->view->params['succ'][] = $msg;
	}
	
	/**
	 * 添加警告信息
	 * @param string $msg
	 */
	protected function addWarnMsg(string $msg) : void {
		if (empty($this->view->params['warn'])) {
			$this->view->params['warn'] = [];
		}
		$this->view->params['warn'][] = $msg;
	}
	
	/**
	 * 添加错误信息
	 * @param string $msg
	 */
	protected function addErrMsg(string $msg) : void {
		if (empty($this->view->params['err'])) {
			$this->view->params['err'] = [];
		}
		$this->view->params['err'][] = $msg;
	}
}