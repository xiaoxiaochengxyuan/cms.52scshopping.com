<?php
namespace app\controllers;
use app\base\BaseWebController;
use app\forms\ProductCatForm;
use app\daos\ProductCat;
use yii\web\Response;
use app\daos\Product;
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
		$result = ['code' => ERROR_CODE_NONE, 'msg' => ''];
		$id = \Yii::$app->request->get('id');
		$productCat = ProductCat::instance()->get($id);
		if (!empty($productCat)) {
			if (ProductCat::instance()->existsByColumn('pid', $id)) {
				$result = ['code' => ERROR_CODE_CANNOT_DELETE, 'msg' => '有子分类不能删除'];
			} elseif (Product::instance()->existsByColumn('cat_id', $id)) {
				$result = ['code' => ERROR_CODE_CANNOT_DELETE, 'msg' => '该分类下有商品不能删除'];
			} elseif (!ProductCat::instance()->delete($id)) {
				$result = ['code' => ERROR_CODE_OPTION_FAILED, 'msg' => '删除分类失败'];
			}
		}
		\Yii::$app->response->format = Response::FORMAT_JSON;
		return $result;
	}
	
	/**
	 * 修改分类
	 */
	public function actionUpdate() {
		$productCatForm = new ProductCatForm();
		$productCatForm->setScenario('update');
		if (\Yii::$app->request->getIsPost()) {
			$post = \Yii::$app->request->post('ProductCatForm');
			$productCatForm->setAttributes($post, false);
			if ($productCatForm->validate() && ProductCat::instance()->update($post['id'], $post)) {
				$this->addSuccMsg('修改分类成功');
			}
		} else {
			$id = \Yii::$app->request->get('id');
			$productCat = ProductCat::instance()->get($id);
			$productCatForm->setAttributes($productCat, false);
		}
		$this->view->title = '修改分类';
		return $this->render('update', ['productCatForm' => $productCatForm]);
	}
	
	/**
	 * 获取子分类的下拉列表
	 */
	public function actionSecondCatDropList() {
		$pid = \Yii::$app->request->get('pid');
		$pid = intval($pid);
		if (empty($pid)) {
			return '';
		}
		$productCats = ProductCat::instance()->dropListData($pid);
		return $this->renderPartial('second-cat-drop-list', ['productCats' => $productCats]);
	}
}