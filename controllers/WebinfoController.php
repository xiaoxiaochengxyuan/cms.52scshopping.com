<?php
namespace app\controllers;
use app\forms\WebinfoForm;
use app\daos\Webinfo;
use app\base\Controller;
/**
 * 网站基本信息Controller
 * @author xiawei
 */
class WebinfoController extends Controller {
	/**
	 * 网站基本信息
	 */
	public function actionIndex() {
		$webinfoForm = new WebinfoForm();
		$webinfoForm->setScenario('edit');
		if (\Yii::$app->request->getIsPost()) {
			$post = \Yii::$app->request->post('WebinfoForm');
			$webinfoForm->setAttributes($post, false);
			if ($webinfoForm->validate() && Webinfo::instance()->edit($post)) {
				$this->addSuccMsg('修改网站基本信息成功');
			}
		} else {
			$webinfo = Webinfo::instance()->getWebinfo();
			$webinfoForm->setAttributes($webinfo, false);
		}
		$this->view->title = '网站基本信息';
		return $this->render('index', ['webinfoForm' => $webinfoForm]);
	}
}