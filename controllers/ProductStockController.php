<?php
namespace app\controllers;
use app\base\Controller;
use app\daos\Product;
use app\forms\ProductStockForm;
use app\daos\ProductStock;
/**
 * 商品库存Controller
 * @author xiawei
 */
class ProductStockController extends Controller {
	/**
	 * 商品库存列表页面
	 */
	public function actionIndex() {
		$productId = \Yii::$app->getRequest()->get('product_id');
		//首先获取对应的商品名称
		$productName = Product::instance()->scalarByPrimaryKey($productId, 'name');
		//获取商品库存
		$productStocks = ProductStock::instance()->indexList($productId);
		$this->view->title = '商品库存管理';
		$renderData = [
			'productName' => $productName,
			'productId' => $productId,
			'productStocks' => $productStocks
		];
		return $this->render('index', $renderData);
	}
	
	
	/**
	 * 添加商品库存
	 * @return string
	 */
	public function actionAdd() {
		$productId = \Yii::$app->getRequest()->get('product_id');
		$productStockForm = new ProductStockForm();
		$productStockForm->setScenario('add');
		if(\Yii::$app->getRequest()->getIsPost()) {
			$post = \Yii::$app->getRequest()->post('ProductStockForm');
			$productStockForm->setAttributes($post, false);
			if ($productStockForm->validate() && ProductStock::instance()->insert($post)) {
				$this->redirect(['/product-stock', 'product_id' => $productId]);
			}
		}
		//获取对应的商品的名称
		$productName = Product::instance()->scalarByPrimaryKey($productId, 'name');
		$productStockForm->product_id = $productId;
		$this->view->title = '添加商品库存';
		$renderData = [
			'productStockForm' => $productStockForm,
			'productId' => $productId,
			'productName' => $productName
		];
		return $this->render('add', $renderData);
	}
	
	/**
	 * 修改商品库存
	 */
	public function actionUpdate() {
		$id = \Yii::$app->getRequest()->get('id');
		$productStockForm = new ProductStockForm();
		$productStockForm->setScenario('update');
		if (\Yii::$app->getRequest()->getIsPost()) {
			$post = \Yii::$app->getRequest()->post('ProductStockForm');
			$productStockForm->setAttributes($post, false);
			if ($productStockForm->validate() && ProductStock::instance()->update($post['id'], $post)) {
				//获取对应的商品Id
				$productId = ProductStock::instance()->scalarByPrimaryKey($post['id'], 'product_id');
				$this->redirect(['/product-stock', 'product_id' => $productId]);
			}
		} else {
			$productStock = ProductStock::instance()->get($id);
			$productStockForm->setAttributes($productStock, false);
		}
		//获取对应的商品的名称
		$productName = Product::instance()->scalarByPrimaryKey($productStockForm->product_id, 'name');
		$this->view->title = '修改商品库存';
		return $this->render('update', [
			'productName' => $productName,
			'productStockForm' => $productStockForm
		]);
	}
	
	/**
	 * 删除操作
	 */
	public function actionDelete() {
		$id = \Yii::$app->getRequest()->get('id');
		if(ProductStock::instance()->delete($id)) {
			return $this->ajaxSuccReturn('删除成功');
		}
		return $this->ajaxErrReturn(ERROR_CODE_CANNOT_DELETE, '删除失败');
	}
}