<?php
namespace app\controllers;
use app\base\Controller;
/**
 * 所有Controller的基类
 * @author xiawei
 */
class IndexController extends Controller {
	/**
	 * 首页控制器
	 * @return string
	 */
	public function actionIndex() {
		return $this->render('index');
	}
}