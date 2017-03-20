<?php
namespace app\controllers;
use app\daos\CollegeDormArea;
use app\daos\College;
use app\forms\CollegeDormAreaForm;
use app\base\Controller;
use app\base\Dao;
use app\daos\Product;
use app\daos\CollegeDormAreaProduct;
use app\daos\ProductStock;
use app\daos\CollegeDormAreaProductStock;
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
	
	/**
	 * 初始化商品
	 * @return \app\base\string[]
	 */
	public function actionInitProduct() {
		$collegeDormAreaId = \Yii::$app->getRequest()->get('collegeDormAreaId');
		if (!CollegeDormArea::instance()->existsByPrimaryKey($collegeDormAreaId)) {
			return $this->ajaxErrReturn(ERROR_CODE_OPTION_FAILED, '对应大学区域不存在');
		}
		$isInitProduct = CollegeDormArea::instance()->scalarByPrimaryKey($collegeDormAreaId, 'is_init_product');
		if ($isInitProduct == 1) {
			return $this->ajaxErrReturn(ERROR_CODE_OPTION_FAILED, '该区域已经初始化过商品,不能重复初始化');
		}
		$db = Dao::db();
		$transaction = $db->beginTransaction();
		//获取所有商品的初始化信息
		$productInitData = Product::instance()->listAll(['id', 'show_buy_number', 'num', 'is_options_num', 'is_jinpin']);
		//首先添加所有商品到大学区域管理表
		foreach ($productInitData as $product) {
			$collegeDormAreaProduct = [
				'product_id' => $product['id'],
				'college_dorm_area_id' => $collegeDormAreaId,
				'show_buy_number' => $product['show_buy_number'],
				'num' => $product['num'],
				'is_options_num' => $productInitData['is_options_num'],
				'is_jinpin' => $productInitData['is_jinpin']
			];
			if (CollegeDormAreaProduct::instance()->insert($collegeDormAreaProduct)) {
				//如果该商品使用的选项库存,那么添加选项库存
				if ($product['is_options_num']) {
					//获取对应刚刚插入的大学区域商品Id
					$collegeDormAreaProductId = $db->getLastInsertID();
					//首先获取该商品所有的选项库存
					$productStocks = ProductStock::instance()->listByColumn('product_id', $product['id']);
					//循环添加选项库存
					foreach ($productStocks as $productStock) {
						$collegeDormAreaProductStock = [
							'college_dorm_area_product_id' => $collegeDormAreaProductId,
							'product_stock_id' => $productStock['id'],
							'num' => $productStock['num'],
							'warning_num' => $productStock['warning_num']
						];
						if (!CollegeDormAreaProductStock::instance()->insert($collegeDormAreaProductStock)) {
							$transaction->rollBack();
							return $this->ajaxErrReturn(ERROR_CODE_OPTION_FAILED, '初始化商品失败');
						}
					}
				}
			} else {
				$transaction->rollBack();
				return $this->ajaxErrReturn(ERROR_CODE_OPTION_FAILED, '初始化商品失败');
			}
		}
		//设置为已经初始化商品
		if (!CollegeDormArea::instance()->update($collegeDormAreaId, ['is_init_product' => 1])) {
			$transaction->rollBack();
			return $this->ajaxErrReturn(ERROR_CODE_OPTION_FAILED, '初始化商品失败');
		}
		$transaction->commit();
		return $this->ajaxSuccReturn('初始化商品成功');
	}
}