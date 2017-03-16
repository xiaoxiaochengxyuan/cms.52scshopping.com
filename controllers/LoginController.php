<?php
namespace app\controllers;
use app\forms\CmsAdminForm;
use app\daos\CmsAdmin;
use app\base\Controller;
/**
 * 管理员登录Controller
 * @author xiawei
 */
class LoginController extends Controller {
	/**
	 * 管理员登录Action
	 * @return string
	 */
	public function actionIndex() {
		$cmsAdminForm = new CmsAdminForm();
		$cmsAdminForm->setScenario('login');
		if (\Yii::$app->request->getIsPost()) {
			$post = \Yii::$app->request->post('CmsAdminForm');
			$cmsAdminForm->setAttributes($post, false);
			if ($cmsAdminForm->validate() && $cmsAdminForm->login()) {
				$this->redirect(['/']);
			}
		}
		return $this->renderPartial('index', ['cmsAdminForm' => $cmsAdminForm]);
	}
	
	/**
	 * 用户退出登录
	 */
	public function actionLogout() {
		CmsAdmin::logout();
		$this->redirect(['/login/logout']);
	}
}