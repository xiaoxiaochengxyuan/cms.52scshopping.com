<?php
namespace app\controllers;
use app\base\BaseWebController;
use app\forms\ProductForm;
use app\daos\ProductCat;
use yii\helpers\Json;
use app\daos\Product;
use yii\data\Pagination;
use yii\web\Response;
/**
 * 商品对应的Controller
 * @author xiawei
 */
class ProductController extends BaseWebController {
	private function beforeSave(array &$post) {
		$post['options'] = trim($post['options']);
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
		
		//接下来把商品选线转化成一个数组
		if (!empty($post['options'])) {
			$options = $post['options'];
			$optionArr = explode("\n", $options);
			$tmpOptionArr = [];
			foreach ($optionArr as $option) {
				$oArr = explode(':', $option);
				$tmpOptionArr[] = ['name' => $oArr[0], 'value' => explode(',', $oArr[1])];
			}
			$post['options'] = $tmpOptionArr;
		} else {
			$post['options'] = [];
		}
	}
	
	/**
	 * 商品列表Action
	 */
	public function actionIndex() {
		$defaultSearch = [
			'name' => '',
			'grounding' => '',
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
		//获取顶级分类
		$topProductCats = ProductCat::instance()->dropListData(0);
		//获取顶级分类下面的二级分类
		$topCatId = empty($search['top_cat_id']) ? array_keys($topProductCats)[0] : $search['top_cat_id'];
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
				$post['options'] = Json::encode($post['options']);
				$post['list_imgs'] = Json::encode($post['list_imgs']);
				if (Product::instance()->update($post['id'], $post)) {
					$this->redirect(['/product']);
				}
			}
		} else {
			$product = Product::instance()->get($id);
			$productForm->setAttributes($product, false);
			$productForm->parameters = Json::decode($productForm->parameters);
			$productForm->options = Json::decode($productForm->options);
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
		
		
		//把选项转化字符串
		if (!empty($productForm->options)) {
			$options = '';
			foreach ($productForm->options as $option) {
				$options .= $option['name'].':'.join(',', $option['value'])."\n";
			}
			$productForm->options = trim($options);
		} else {
			$productForm->options = '';
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
		if (\Yii::$app->request->getIsPost()) {
			$post = \Yii::$app->request->post('ProductForm');
			$this->beforeSave($post);
			$productForm->setAttributes($post, false);
			if ($productForm->validate()) {
				$post['parameters'] = Json::encode($post['parameters']);
				$post['options'] = Json::encode($post['options']);
				$post['list_imgs'] = Json::encode($post['list_imgs']);
				if (Product::instance()->insert($post)) {
					$this->redirect(['/product']);
				}
			}
			
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
		
		
		//把选项转化字符串
		if (!empty($productForm->options)) {
			$options = '';
			foreach ($productForm->options as $option) {
				$options .= $option['name'].':'.join(',', $option['value'])."\n";
			}
			$productForm->options = trim($options);
		} else {
			$productForm->options = '';
		}
		
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
}