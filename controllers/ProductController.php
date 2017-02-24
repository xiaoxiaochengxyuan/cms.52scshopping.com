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
		if (\Yii::$app->request->getIsPost()) {
			$post = \Yii::$app->request->post('ProductForm');
			
			//首先把params转化成数组
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
			
			//接下来把商品选线转化成一个数组
			$options = $post['options'];
			$optionArr = explode("\n", $options);
			$tmpOptionArr = [];
			foreach ($optionArr as $option) {
				$oArr = explode(':', $option);
				$tmpOptionArr[] = ['name' => $oArr[0], 'value' => explode(',', $oArr[1])];
			}
			$post['options'] = $tmpOptionArr;
			
			$productForm->setAttributes($post, false);
			if ($productForm->validate()) {
				
			}
			
		}
		
		//首先把对应的选项和params转化成字符串
		if (!empty($productForm->parameters)) {
			$parameters = '';
			foreach ($productForm->parameters as $parameter) {
				$parameters .= join(':', $parameter)."\n";
			}
			$productForm->parameters = $parameters;
		}
		
		//把选项转化字符串
		if (!empty($productForm->options)) {
			$options = '';
			foreach ($productForm->options as $option) {
				$options .= $option['name'].':'.join(',', $option['value'])."\n";
			}
			$productForm->options = trim($options);
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
}