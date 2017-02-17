<?php
namespace app\controllers;
use app\base\BaseWebController;
use app\forms\CmsAdminForm;
/**
 * 管理员登录Controller
 * @author xiawei
 */
class LoginController extends BaseWebController {
	public function actionIndex() {
		$cmsAdminForm = new CmsAdminForm();
		$cmsAdminForm->setScenario('login');
		if (\Yii::$app->request->getIsPost()) {
			$post = \Yii::$app->request->post('CmsAdminForm');
			$cmsAdminForm->setAttributes($post, false);
			if ($cmsAdminForm->validate() && $cmsAdminForm->login()) {
				
			}
		}
		return $this->renderPartial('index', ['cmsAdminForm' => $cmsAdminForm]);
	}
}