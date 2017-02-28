<?php
namespace app\controllers;
use app\base\BaseWebController;
use app\forms\CmsAdminForm;
use app\daos\CmsAdmin;
/**
 * Cms管理员对象
 * @author xiawei
 */
class CmsAdminController extends BaseWebController {
	/**
	 * 修改当前登录用户密码Action
	 */
	public function actionChgMyPasswd() {
		$cmsAdminForm = new CmsAdminForm();
		$cmsAdminForm->setScenario('chg-my-passwd');
		if (\Yii::$app->request->getIsPost()) {
			$post = \Yii::$app->request->post('CmsAdminForm');
			$cmsAdminForm->setAttributes($post, false);
			$currentLoginId = CmsAdmin::loginInfo('id');
			if ($cmsAdminForm->validate() && CmsAdmin::instance()->changePasswd($currentLoginId, $post['password'])) {
				$this->addSuccMsg('修改密码成功!');
			}
		}
		$this->view->title = '修改密码';
		return $this->render('chg-my-passwd', ['cmsAdminForm' => $cmsAdminForm]);
	}
}