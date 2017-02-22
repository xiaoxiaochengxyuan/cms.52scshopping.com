<?php
namespace app\controllers;
use app\base\BaseWebController;
use app\forms\CollegeForm;
use app\daos\Region;
use app\daos\College;
use yii\data\Pagination;
/**
 * 大学相关的Controller
 * @author xiawei
 */
class CollegeController extends BaseWebController {
	/**
	 * 大学列表页Controller
	 */
	public function actionIndex() {
		$pagination = new Pagination();
		$pagination->totalCount = College::instance()->count();
		$pagination->pageSize = 20;
		$colleges = College::instance()->pageColleges($pagination);
		$this->view->title = '大学列表';
		return $this->render('index', ['colleges' => $colleges, 'pagination' => $pagination]);
	}
	
	/**e
	 * 添加一个大学
	 */
	public function actionAdd() {
		$collegeForm = new CollegeForm();
		$collegeForm->setScenario('add');
		
		if (\Yii::$app->request->getIsPost()) {
			$post = \Yii::$app->request->post('CollegeForm');
			$collegeForm->setAttributes($post, false);
			if ($collegeForm->validate() && College::instance()->insert($post)) {
				$this->addSuccMsg('添加大学成功');
			}
		}
		
		//首先获取所有的省
		$provinces = Region::instance()->provinceDroplistData();
		$provinceId = empty($collegeForm->province_id) ? array_keys($provinces)[0] : $collegeForm->province_id;
		//对应的城市
		$cities = Region::instance()->droplistData($provinceId);
		$cityId = empty($collegeForm->city_id) ? array_keys($cities)[0] : $collegeForm->city_id;
		
		//对应的区域
		$regions = Region::instance()->droplistData($cityId);
		$this->view->title = '添加大学';
		return $this->render('add', [
			'collegeForm' => $collegeForm,
			'provinces' => $provinces,
			'cities' => $cities,
			'regions' => $regions,
		]);
	}
	
	/**
	 * 修改一个大学
	 */
	public function actionUpdate() {
		$collegeForm = new CollegeForm();
		$collegeForm->setScenario('update');
		if (\Yii::$app->request->getIsPost()) {
			$post = \Yii::$app->request->post('CollegeForm');
			$collegeForm->setAttributes($post, false);
			if ($collegeForm->validate() && College::instance()->update($post['id'], $post)) {
				$this->addSuccMsg('修改大学成功');
			}
		} else {
			$id = \Yii::$app->request->get('id');
			$college = College::instance()->get($id);
			$collegeForm->setAttributes($college, false);
		}
		
		//首先获取所有的省
		$provinces = Region::instance()->provinceDroplistData();
		$provinceId = empty($collegeForm->province_id) ? array_keys($provinces)[0] : $collegeForm->province_id;
		//对应的城市
		$cities = Region::instance()->droplistData($provinceId);
		$cityId = empty($collegeForm->city_id) ? array_keys($cities)[0] : $collegeForm->city_id;
		
		//对应的区域
		$regions = Region::instance()->droplistData($cityId);
		$this->view->title = '修改大学';
		return $this->render('update', [
			'collegeForm' => $collegeForm,
			'provinces' => $provinces,
			'cities' => $cities,
			'regions' => $regions,
		]);
	}
}