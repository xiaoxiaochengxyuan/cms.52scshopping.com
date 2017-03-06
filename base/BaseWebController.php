<?php
namespace app\base;
use yii\web\Controller;
use yii\web\Response;
/**
 * 所以Controller的基类
 * @author xiawei
 */
abstract class BaseWebController extends Controller {
	/**
	 * {@inheritDoc}
	 * @see \yii\base\Component::behaviors()
	 */
	public function behaviors() {
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
	private function defineStatic() {
		defined('STATIC_URL') or define('STATIC_URL', \Yii::$app->urlManager->baseUrl.'/static');
		defined('ACE_STATIC_URL') or define('ACE_STATIC_URL', STATIC_URL.'/ace');
		defined('ACE_STATIC_JS_URL') or define('ACE_STATIC_JS_URL', ACE_STATIC_URL.'/js');
		defined('ACE_STATIC_CSS_URL') or define('ACE_STATIC_CSS_URL', ACE_STATIC_URL.'/css');
		defined('ACE_STATIC_AVATOR_URL') or define('ACE_STATIC_AVATOR_URL', ACE_STATIC_URL.'/avatars');
		defined('CMS_STATIC_URL') or define('CMS_STATIC_URL', STATIC_URL.'/cms');
		defined('CMS_STATIC_CSS_URL') or define('CMS_STATIC_CSS_URL', CMS_STATIC_URL.'/css');
		defined('UPLOADIFY_STATIC_URL') or define('UPLOADIFY_STATIC_URL', STATIC_URL.'/uploadify');
		defined('KINDEDITOR_STATIC_URL') or define('KINDEDITOR_STATIC_URL', STATIC_URL.'/kindeditor');
		defined('KINDEDITOR_LANG_STATIC_URL') or define('KINDEDITOR_LANG_STATIC_URL', KINDEDITOR_STATIC_URL.'/lang');
		defined('KINDEDITOR_PLUGINS_STATIC_URL') or define('KINDEDITOR_PLUGINS_STATIC_URL', KINDEDITOR_STATIC_URL.'/plugins');
		defined('KINDEDITOR_THEMES_STATIC_URL') or define('KINDEDITOR_THEMES_STATIC_URL', KINDEDITOR_STATIC_URL.'/themes');
	}
	
	/**
	 * 添加成功信息
	 * @param string $msg 成功信息
	 */
	protected function addSuccMsg($msg) {
		if (empty($this->view->params['succ'])) {
			$this->view->params['succ'] = [];
		}
		$this->view->params['succ'][] = $msg;
	}
	
	/**
	 * 添加警告信息
	 * @param string $msg
	 */
	protected function addWarnMsg($msg) {
		if (empty($this->view->params['warn'])) {
			$this->view->params['warn'] = [];
		}
		$this->view->params['warn'][] = $msg;
	}
	
	/**
	 * 添加错误信息
	 * @param string $msg
	 */
	protected function addErrMsg($msg) {
		if (empty($this->view->params['err'])) {
			$this->view->params['err'] = [];
		}
		$this->view->params['err'][] = $msg;
	}
	
	
	/**
	 * 成功返回信息
	 * @return string[]
	 */
	protected function ajaxSuccReturn($msg = '操作成功') {
		$result = ['code' => ERROR_CODE_NONE, 'msg' => $msg];
		\Yii::$app->response->format = Response::FORMAT_JSON;
		return $result;
	}
	
	/**
	 * 错误的返回信息
	 * @param integer $code 错误代码
	 * @param string $msg 错误信息
	 * @return array
	 */
	protected function ajaxErrReturn($code, $msg) {
		$result = ['code' => $code, 'msg' => $msg];
		\Yii::$app->response->format = Response::FORMAT_JSON;
		return $result;
	}
}