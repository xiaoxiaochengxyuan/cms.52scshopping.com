<?php
namespace app\controllers;
use app\base\BaseWebController;
use app\forms\CmsAdminForm;
use app\daos\CmsAdmin;
/**
 * 管理员登录Controller
 * @author xiawei
 */
class LoginController extends BaseWebController {
	/**
	 * 管理员登录Action
	 * @return string
	 */
	public function actionIndex() : string {
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