<?php
namespace app\controllers;
use app\base\BaseWebController;
use app\forms\ProductCatForm;
use app\daos\ProductCat;
/**
 * 商品分类对应的Controller
 * @author xiawei
 */
class ProductCatController extends BaseWebController {
	/**
	 * 商品分类列表页
	 */
	public function actionIndex() {
		$pid = \Yii::$app->request->get('pid', 0);
		$this->view->title = '商品分类列表';
		if ($pid == 0) {
			$this->view->title = '商品顶级分类列表';
		}
		$productCats = ProductCat::instance()->getIndexData($pid);
		return $this->render('index', ['pid' => $pid, 'productCats' => $productCats]);
	}
	
	/**
	 * 添加商品
	 */
	public function actionAdd() {
		$productCatForm = new ProductCatForm();
		$productCatForm->setScenario('add');
		if (\Yii::$app->request->getIsPost()) {
			$post = \Yii::$app->request->post('ProductCatForm');
			$productCatForm->setAttributes($post, false);
			if ($productCatForm->validate() && ProductCat::instance()->insert($post)) {
				$this->redirect(['/product-cat', 'pid' => $post['pid']]);
			}
		} else {
			$pid = \Yii::$app->request->get('pid');
			$productCatForm->pid = $pid;
		}
		$this->view->title = '添加商品分类';
		if ($productCatForm->pid == 0) {
			$this->view->title = '添加顶级商品分类';
		}
		return $this->render('add', ['productCatForm' => $productCatForm]);
	}
	
	/**
	 * 删除分类
	 */
	public function actionDelete() {
		$id = \Yii::$app->request->get('id');
		$transaction = ProductCat::db()->beginTransaction();
		if (ProductCat::instance()->delete($id) !== false && ProductCat::instance()->deleteByColumn('pid', $id) !== false) {
			$transaction->commit();
		} else {
			$transaction->rollBack();
		}
		return 'success';
	}
	
	/**
	 * 修改分类
	 */
	public function actionUpdate() {
		$id = \Yii::$app->request->get('id');
		$productCat = ProductCat::instance()->get($id);
		$productCatForm = new ProductCatForm();
		$productCatForm->setScenario('update');
		$productCatForm->setAttributes($productCat, false);
		return $this->render('update', ['productCatForm' => $productCatForm]);
	}
}