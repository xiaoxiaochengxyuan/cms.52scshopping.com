<?php
namespace app\controllers;
use app\base\BaseWebController;
use app\forms\CollegeAdminForm;
use app\daos\CollegeAdmin;
use yii\data\Pagination;
/**
 * 大学管理员Controller
 * @author xiawei
 */
class CollegeAdminController extends BaseWebController {
	/**
	 * 大学管理员列表
	 */
	public function actionIndex() {
		$college_id = \Yii::$app->request->get('college_id');
		$pagination = new Pagination();
		$pagination->totalCount = CollegeAdmin::instance()->countByColumn('college_id', $college_id);
		$pagination->pageSize = 20;
		$collegeAdmins = CollegeAdmin::instance()->pageByColumn($pagination, 'college_id', $college_id);
		$this->view->title = '大学管理员列表';
		return $this->render('index', ['college_id' => $college_id, 'collegeAdmins' => $collegeAdmins, 'pagination' => $pagination]);
	}
	
	/**
	 * 添加大学管理员
	 */
	public function actionAdd() {
		$collegeAdminForm = new CollegeAdminForm();
		$collegeAdminForm->setScenario('add');
		if (\Yii::$app->request->getIsPost()) {
			$post = \Yii::$app->request->post('CollegeAdminForm');
			$collegeAdminForm->setAttributes($post, false);
			if ($collegeAdminForm->validate() && CollegeAdmin::instance()->insert($post)) {
				$this->addSuccMsg('添加大学管理员成功');
			}
		} else {
			$college_id = \Yii::$app->request->get('college_id');
			$collegeAdminForm->college_id = $college_id;
		}
		$this->view->title = '添加大学管理员';
		return $this->render('add', ['collegeAdminForm' => $collegeAdminForm]);
	}
	
	/**
	 * 修改管理员
	 * @return string
	 */
	public function actionUpdate() {
		$collegeAdminForm = new CollegeAdminForm();
		$collegeAdminForm->setScenario('update');
		if (\Yii::$app->request->getIsPost()) {
			$post = \Yii::$app->request->post('CollegeAdminForm');
			$collegeAdminForm->setAttributes($post, false);
			if ($collegeAdminForm->validate() && CollegeAdmin::instance()->update($post['id'], $post)) {
				$this->addSuccMsg('修改校园管理员成功');
			}
		} else {
			$id = \Yii::$app->request->get('id');
			$collegeAdmin = CollegeAdmin::instance()->get($id);
			$collegeAdminForm->setAttributes($collegeAdmin, false);
		}
		$this->view->title = '修改管理员';
		return $this->render('update', ['collegeAdminForm' => $collegeAdminForm]);
	}
	
	/**
	 * 删除管理员
	 */
	public function actionDelete(){
		$id = \Yii::$app->request->get('id');
		CollegeAdmin::instance()->delete($id);
		return 'success';
	}
	
	/**
	 * 重置管理员密码
	 */
	public function actionResetPassword() {
		$id = \Yii::$app->request->get('id');
		CollegeAdmin::instance()->resetPassword($id);
		return 'success';
	}
}