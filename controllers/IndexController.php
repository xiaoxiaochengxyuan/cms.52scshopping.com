<?php
namespace app\controllers;
use app\base\BaseWebController;
use app\daos\CmsAdmin;
/**
 * 所有Controller的基类
 * @author xiawei
 */
class IndexController extends BaseWebController {
	public function actionIndex() {
		var_dump(CmsAdmin::instance()->columns());exit();
	}
}