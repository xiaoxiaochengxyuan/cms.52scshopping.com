<?php
namespace app\forms;
use yii\base\Model;
use app\utils\CommonUtil;
use app\daos\ProductCat;
/**
 * 商品表单
 * @author xiawei
 */
class ProductForm extends Model {
	/**
	 * 商品id
	 * @var integer
	 */
	public $id = 0;
	
	/**
	 * 商品名称
	 * @var string
	 */
	public $name = null;
	
	/**
	 * 商品价格
	 * @var double
	 */
	public $price = 0;
	
	
	/**
	 * 页面上初始显示的商品购买数量
	 * @var integer
	 */
	public $show_buy_number = 0;
	
	
	/**
	 * 商品参数
	 * @var string
	 */
	public $parameters = null;
	
	
	/**
	 * 商品详情
	 * @var string
	 */
	public $desc = null;
	
	
	/**
	 * 标题图片
	 * @var string
	 */
	public $title_img = null;
	
	
	/**
	 * 列表图片
	 * @var string
	 */
	public $list_imgs = null;
	
	/**
	 * 顶级的分类id
	 * @var integer
	 */
	public $top_cat_id = 0;
	
	/**
	 * 分类id
	 * @var integer
	 */
	public $cat_id = 0;
	
	
	/**
	 * 是否是缺货必发
	 * @var int 
	 */
	public $need_send = 0;
	
	
	/**
	 * 进货价格
	 * @var integer
	 */
	public $stock_price = 0;
	
	
	
	/**
	 * 是否上线,0为否,1为是
	 * @var integer
	 */
	public $grounding = 0;
	
	/**
	 * 进货URL
	 * @var string
	 */
	public $purchase_url = null;
	
	/**
	 * {@inheritDoc}
	 * @see \yii\base\Model::rules()
	 */
	public function rules() {
		return [
			['name', 'required', 'on' => ['add', 'update'], 'message' => '商品名称必须填写'],
			['stock_price', 'checkStockPrice', 'on' => ['add', 'update'], 'skipOnEmpty' => false],
			['price', 'checkPrice', 'on' => ['add', 'update'], 'skipOnEmpty' => false],
			['show_buy_number', 'checkShowBuyNumber', 'on' => ['add', 'update'], 'skipOnEmpty' => false],
			['parameters', 'checkParamters', 'on' => ['add', 'update'], 'skipOnEmpty' => false],
			['desc', 'required', 'on' => ['add', 'update'], 'message' => '商品详情不能为空'],
			['title_img', 'required', 'on' => ['add', 'update'], 'message' => '标题图片不正确'],
			['list_imgs', 'checkListImg', 'on' => ['add', 'update'], 'skipOnEmpty' => false],
			['top_cat_id', 'checkTopCatId', 'on' => ['add', 'update'], 'skipOnEmpty' => false],
			['cat_id', 'checkCatId', 'on' => ['add', 'update'], 'skipOnEmpty' => false],
			['need_send', 'checkNeedSend', 'on' => ['add', 'update'], 'skipOnEmpty' => false],
			['purchase_url', 'url', 'on' => ['add', 'update'], 'skipOnEmpty' => false]
		];
	}
	
	/**
	 * 检查进货价格
	 */
	public function checkStockPrice() {
		if (!CommonUtil::isPlusNumber($this->stock_price)) {
			$this->addError('stock_price', '商品进货价格必须是一个正数');
		}
	}
	
	/**
	 * 检查商品价格
	 */
	public function checkPrice() {
		if (!is_numeric($this->price)) {
			$this->addError('price', '商品价格必须是一个数字');
		} elseif ($this->price < $this->stock_price) {
			$this->addError('price', '商品价格不能小于进货价格');
		}
	}
	
	/**
	 * 检查商品库存
	 */
	public function checkNumber() {
		if (!empty($this->options) && !CommonUtil::isPlusNumber($this->number)) {
			$this->addError('number', '商品库存必须是一个正数');
		}
	}
	
	/**
	 * 检查显示购买人数
	 */
	public function checkShowBuyNumber() {
		if (!CommonUtil::isPlusNumber($this->show_buy_number)) {
			$this->addError('show_buy_number', '初始显示购买人数不能为空');
		}
	}
	
	/**
	 * 检查参数
	 */
	public function checkParamters() {
		foreach ($this->parameters as $parameter) {
			if (!isset($parameter['name']) && !isset($parameter['value'])) {
				$this->addError('parameters', '不能有空行');
				break;
			}
			if (!isset($parameter['name'])) {
				$this->addError('parameters', "值为‘{$parameter['value']}’的参数没有对应的名称");
				break;
			}
			if (!isset($parameter['value'])) {
				$this->addError('parameters', "名称为‘{$parameter['value']}’的参数没有对应值");
				break;
			}
		}
	}
	
	
	/**
	 * 检查列表图片
	 */
	public function checkListImg() {
		if (empty($this->list_imgs)) {
			$this->addError('list_imgs', '列表图片必须上传');
		} else {
			foreach ($this->list_imgs as $img) {
				if (empty($img)) {
					$this->addError('list_imgs', '列表图片有错');
				}
			}
		}
	}
	
	/**
	 * 检查顶级分类Id
	 */
	public function checkTopCatId() {
		$topProductCat = ProductCat::instance()->get($this->top_cat_id);
		if (empty($topProductCat)) {
			$this->addError('top_cat_id', '没有该顶级分类');
		} elseif ($topProductCat['pid'] != 0) {
			$this->addError('top_cat_id', '该顶级分类不是顶级分类');
		}
	}
	
	/**
	 * 检查普通分类Id
	 */
	public function checkCatId() {
		$productCat = ProductCat::instance()->get($this->cat_id);
		if (empty($productCat)) {
			$this->addError('top_cat_id', '没有该普通分类');
		} elseif ($productCat['pid'] == 0) {
			$this->addError('top_cat_id', '该普通分类是顶级分类');
		}
	}
	
	/**
	 * 验证缺货必发
	 */
	public function checkNeedSend() {
		if (!in_array($this->need_send, [0, 1])) {
			$this->addError('need_send', '是否时缺货必发不正确');
		}
	}
}