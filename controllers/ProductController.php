<?php
namespace app\controllers;
use app\base\BaseWebController;
use app\forms\ProductForm;
use app\daos\ProductCat;
/**
 * 商品对应的Controller
 * @author xiawei
 */
class ProductController extends BaseWebController {
	/**
	 * 商品列表Action
	 */
	public function actionIndex() {
		$this->view->title = '商品列表页';
		return $this->render('index');
	}
	
	
	public function actionAdd() {
		$productForm = new ProductForm();
		$productForm->setScenario('add');
		//首先查询出所有的顶级商品分类
		$topProductCats = ProductCat::instance()->dropListData(0);
		//获取被选中的商品分类Id
		$selectTopProductCatId = array_keys($topProductCats)[0];
		//获取对应的二级商品分类Id
		$productCats = ProductCat::instance()->dropListData($selectTopProductCatId);
		$this->view->title = '添加商品';
		return $this->render('add', ['productForm' => $productForm, 'topProductCats' => $topProductCats, 'productCats' => $productCats]);
	}
}