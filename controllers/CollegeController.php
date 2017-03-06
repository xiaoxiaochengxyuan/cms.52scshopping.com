<?php
namespace app\controllers;
use app\base\BaseWebController;
use app\forms\CollegeForm;
use app\daos\Region;
use app\daos\College;
use yii\data\Pagination;
use app\daos\Product;
use app\base\BaseDao;
use app\daos\CollegeProduct;
use yii\web\Response;
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
	
	
	public function actionInitProduct() {
		$result = ['code' => ERROR_CODE_NONE, 'msg' => '操作成功'];
		$collegeId = \Yii::$app->getRequest()->get('collegeId');
		//首先查看对应的大学是否已经被初始化过
		$hasInit = College::instance()->scalarByPrimaryKey($collegeId, 'has_init_product');
		//当还没有初始化过商品,那么进行初始化
		if ($hasInit == 0 && $hasInit !== false) {
			//获取数据库中所有商品
			$products = Product::instance()->listAll(['id', 'number', 'show_buy_number']);
			$transaction = BaseDao::db()->beginTransaction();
			$flag = true;
			//循环添加大学商品
			foreach ($products as $product) {
				$collegeProduct = [
					'product_id' => $product['id'],
					'college_id' => $collegeId,
					'number' => $product['number'],
					'show_buy_number' => $product['show_buy_number'],
				];
				$flag = $flag && CollegeProduct::instance()->insert($collegeProduct);
				if (!$flag) {
					break;
				}
			}
			if ($flag) {
				//设置大学已经初始化过商品了
				$flag = $flag && College::instance()->update($collegeId, ['has_init_product' => 1]);
			}
			if ($flag) {
				$transaction->commit();
			} else {
				$transaction->rollBack();
				$result = ['code' => ERROR_CODE_OPTION_FAILED, 'msg' => '操作失败'];
			}
		}
		\Yii::$app->getResponse()->format = Response::FORMAT_JSON;
		return $result;
	}
}