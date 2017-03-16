<?php
namespace app\controllers;
use app\forms\ProductForm;
use app\daos\ProductCat;
use yii\helpers\Json;
use app\daos\Product;
use yii\data\Pagination;
use yii\web\Response;
use app\base\Controller;
/**
 * 商品对应的Controller
 * @author xiawei
 */
class ProductController extends Controller {
	private function beforeSave(array &$post) {
		$post['parameters'] = trim($post['parameters']);
		
		//首先把params转化成数组
		if (!empty($post['parameters'])) {
			$parameters = $post['parameters'];
			$parameterArr = explode("\n", $parameters);
			foreach ($parameterArr as $key => $pa) {
				if (empty(trim($pa))) {
					unset($parameterArr[$key]);
				}
			}
				
			$temPArr = [];
			foreach ($parameterArr as $p) {
				$pArr = explode(':', $p);
				$temPArr[] = ['name' => $pArr[0], 'value' => $pArr[1]];
			}
				
			$post['parameters'] = $temPArr;
		} else {
			$post['parameters'] = [];
		}
	}
	
	/**
	 * 商品列表Action
	 */
	public function actionIndex() {
		$defaultSearch = [
			'name' => '',
			'grounding' => -1,
			'stock_price_min' => '',
			'stock_price_max' => '',
			'top_cat_id' => '',
			'cat_id' => ''
		];
		$search = \Yii::$app->request->get('search', $defaultSearch);
		$pagionation = new Pagination();
		$pagionation->totalCount = Product::instance()->countBySearch($search);
		$pagionation->pageSize = 20;
		$products = Product::instance()->pageBySearch($search, $pagionation);
		$topProductCats = ProductCat::instance()->dropListData(0);
		$topCatId = $search['top_cat_id'];
		if (empty($topCatId)) {
			$topCatId = array_keys($topProductCats)[0];
		}
		$productCats = ProductCat::instance()->dropListData($topCatId);
		$this->view->title = '商品列表页';
		return $this->render('index', [
			'products' => $products,
			'pagination' => $pagionation,
			'search' => $search,
			'topProductCats' => $topProductCats,
			'productCats' => $productCats
		]);
	}
	
	/**
	 * 修改商品Action
	 */
	public function actionUpdate() {
		$id = \Yii::$app->request->get('id');
		$productForm = new ProductForm();
		$productForm->setScenario('update');
		if (\Yii::$app->request->getIsPost()) {
			$post = \Yii::$app->request->post('ProductForm');
			$this->beforeSave($post);
			$productForm->setAttributes($post, false);
			if ($productForm->validate()) {
				$post['parameters'] = Json::encode($post['parameters']);
				$post['list_imgs'] = Json::encode($post['list_imgs']);
				if (Product::instance()->update($post['id'], $post)) {
					$this->redirect(['/product']);
				}
			}
		} else {
			$product = Product::instance()->get($id);
			$productForm->setAttributes($product, false);
			$productForm->parameters = Json::decode($productForm->parameters);
		}
		
		
		//首先把对应的选项和params转化成字符串
		if (!empty($productForm->parameters)) {
			$parameters = '';
			foreach ($productForm->parameters as $parameter) {
				$parameters .= join(':', $parameter)."\n";
			}
			$productForm->parameters = $parameters;
		} else {
			$productForm->parameters = '';
		}
		
		if (is_string($productForm->list_imgs)) {
			$productForm->list_imgs = Json::decode($productForm->list_imgs);
		}
		
		//首先查询出所有的顶级商品分类
		$topProductCats = ProductCat::instance()->dropListData(0);
		//获取对应的二级商品分类Id
		$productCats = ProductCat::instance()->dropListData($productForm->top_cat_id);
		
		$this->view->title = '修改商品';
		return $this->render('update', [
			'productForm' => $productForm,
			'topProductCats' => $topProductCats,
			'productCats' => $productCats
		]);
	}
	
	
	public function actionAdd() {
		$productForm = new ProductForm();
		$productForm->setScenario('add');
		$postArr = [
			'parameters' => ''
		];
		if (\Yii::$app->request->getIsPost()) {
			$post = \Yii::$app->request->post('ProductForm');
			$postArr['parameters'] = $post['parameters'];
			$postArr['options'] = $post['options'];
			try {
				$this->beforeSave($post);
				$productForm->setAttributes($post, false);
				if ($productForm->validate()) {
					$post['parameters'] = Json::encode($post['parameters']);
					$post['list_imgs'] = Json::encode($post['list_imgs']);
					if (Product::instance()->insert($post)) {
						$this->redirect(['/product']);
					}
				}
			} catch (\Exception $e) {
				$productForm->setAttributes($post, false);
				$this->addErrMsg('商品参数或者选项错误!');
			}
		}
		
		$productForm->parameters = $postArr['parameters'];
		
		//首先查询出所有的顶级商品分类
		$topProductCats = ProductCat::instance()->dropListData(0);
		//获取被选中的商品分类Id
		$selectTopProductCatId = empty($productForm->top_cat_id) ? array_keys($topProductCats)[0] : $productForm->top_cat_id;
		//获取对应的二级商品分类Id
		$productCats = ProductCat::instance()->dropListData($selectTopProductCatId);
		$this->view->title = '添加商品';
		return $this->render('add', ['productForm' => $productForm, 'topProductCats' => $topProductCats, 'productCats' => $productCats]);
	}
	
	
	/**
	 * 修改是否上架
	 * @return string[]
	 */
	public function actionChgGrounding() {
		$id = \Yii::$app->request->get('id');
		$grounding = Product::instance()->scalarByPrimaryKey($id, 'grounding');
		$result = ['code' => ERROR_CODE_NONE, 'msg' => '操作成功'];
		if ($grounding == 0) {
			$updateGrounding = 1;
		} else {
			$updateGrounding = 0;
		}
		if (!Product::instance()->update($id, ['grounding' => $updateGrounding])) {
			$result = ['code' => ERROR_CODE_OPTION_FAILED, 'msg' => '修改是否上架错误'];
		}
		\Yii::$app->response->format = Response::FORMAT_JSON;
		return $result;
	}
	
	/**
	 * 删除商品
	 */
	public function actionDelete() {
		$id = \Yii::$app->getRequest()->get('id');
		if (Product::instance()->existsByPrimaryKey($id)) {
			if (Product::instance()->delete($id)) {
				return $this->ajaxSuccReturn('删除商品成功');
			} else {
				return $this->ajaxErrReturn(ERROR_CODE_OPTION_FAILED, '删除商品失败');
			}
		} else {
			return $this->ajaxErrReturn(ERROR_CODE_CANNOT_DELETE, '该商品已经被删除');
		}
	}
}