<?php
namespace app\controllers;
use app\base\BaseWebController;
use app\forms\CollegeForm;
use app\daos\Region;
/**
 * 大学相关的Controller
 * @author xiawei
 */
class CollegeController extends BaseWebController {
	/**
	 * 大学列表页Controller
	 */
	public function actionIndex() {
		$this->view->title = '大学列表';
		return $this->render('index');
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
}