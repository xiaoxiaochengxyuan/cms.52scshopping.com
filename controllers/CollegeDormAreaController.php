<?php
namespace app\controllers;
use app\daos\CollegeDormArea;
use app\daos\College;
use app\forms\CollegeDormAreaForm;
use app\base\Controller;
/**
 * 大学宿舍区域管理
 * @author xiawei
 */
class CollegeDormAreaController extends Controller {
	/**
	 * 大学宿舍区域列表页
	 */
	public function actionIndex() {
		//首先获取对应的大学Id
		$collegeId = \Yii::$app->getRequest()->get('college_id');
		//获取对应的大学区域
		$collegeDormAreas = CollegeDormArea::instance()->indexData($collegeId);
		//获取到对应的大学
		$college = College::instance()->get($collegeId);
		$this->view->title = '大学宿舍区域列表';
		return $this->render('index', ['collegeDormAreas' => $collegeDormAreas, 'college' => $college]);
	}
	
	
	/**
	 * 添加大学宿舍区域
	 */
	public function actionAdd() {
		$collegeId = \Yii::$app->getRequest()->get('college_id');
		$collegeDormAreaForm = new CollegeDormAreaForm();
		$collegeDormAreaForm->college_id = $collegeId;
		$collegeDormAreaForm->setScenario('add');
		if (\Yii::$app->getRequest()->getIsPost()) {
			$post = \Yii::$app->getRequest()->post('CollegeDormAreaForm');
			$collegeDormAreaForm->setAttributes($post, false);
			if ($collegeDormAreaForm->validate()) {
				if (!College::instance()->existsByPrimaryKey($collegeId)) {
					$this->addErrMsg('对应的大学被删除,不能添加');
				} elseif (CollegeDormArea::instance()->insert($post)) {
					$this->redirect(['/college-dorm-area', 'college_id' => $collegeId]);
				}
			}
		}
		$this->view->title = '添加大学宿舍区域';
		return $this->render('add', ['collegeDormAreaForm' => $collegeDormAreaForm]);
	}
}