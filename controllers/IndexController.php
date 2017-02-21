<?php
namespace app\controllers;
use app\base\BaseWebController;
/**
 * 所有Controller的基类
 * @author xiawei
 */
class IndexController extends BaseWebController {
	/**
	 * 首页控制器
	 * @return string
	 */
	public function actionIndex() {
		return $this->render('index');
	}
}