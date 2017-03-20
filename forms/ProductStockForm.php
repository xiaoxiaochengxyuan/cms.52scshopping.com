<?php
namespace app\forms;
use yii\base\Model;
use app\utils\CommonUtil;
use app\daos\Product;
/**
 * 商品库存表单
 * @author xiawei
 */
class ProductStockForm extends Model {
	/**
	 * 自增Id
	 * @var integer
	 */
	public $id = 0;
	
	/**
	 * 库存对应的名称
	 * @var string
	 */
	public $name = null;
	
	/**
	 * 初始化商品库存
	 * @var integer
	 */
	public $num = 0;
	
	
	/**
	 * 警告商品库存
	 * @var integer
	 */
	public $warning_num = 0;
	
	
	/**
	 * 对应的商品Id
	 * @var integer
	 */
	public $product_id = 0;
	
	
	/**
	 * 进货价格
	 * @var double
	 */
	public $stock_price = 0;
	
	/**
	 * 实际售价
	 * @var double
	 */
	public $price = 0;
	
	/**
	 * {@inheritDoc}
	 * @see \yii\base\Model::rules()
	 */
	public function rules() {
		return [
				['name', 'required', 'on' => ['add', 'update'], 'message' => '库存名称必须填写'],
			['num', 'checkNum', 'on' => ['add', 'update'], 'skipOnEmpty' => false],
			['warning_num', 'checkWarningNum', 'on' => ['add', 'update'], 'skipOnEmpty' => false],
			['stock_price', 'checkStockPrice', 'on' => ['add', 'update']],
			['price', 'checkPrice', 'on' => ['add', 'update']],
			['product_id', 'checkProductId', 'on' => ['add'], 'skipOnEmpty' => false]
		];
	}
	
	/**
	 * 检查初始化库存
	 */
	public function checkNum() {
		if (!CommonUtil::isPlusNumber($this->num)) {
			$this->addError('num', '初始化商品库存必须为一个正整数');
		}
	}
	
	/**
	 * 检查商品警告库存
	 */
	public function checkWarningNum() {
		if (!CommonUtil::isPlusNumber($this->warning_num)) {
			$this->addError('warning_num', '商品警告库存必须为一个正整数');
		}
	}
	
	/**
	 * 检查进货价格
	 */
	public function checkStockPrice() {
		if (!empty($this->stock_price) && !(is_numeric($this->stock_price) && $this->stock_price > 0)) {
			$this->addError('stock_price', '进货价格必须是一个正数');
		}
	}
	
	/**
	 * 检查价格
	 */
	public function checkPrice() {
		if (!empty($this->price) && !(is_numeric($this->price) && $this->price > 0)) {
			$this->addError('price', '商品售价必须是一个正数');
		}
	}
	
	/**
	 * 检查商品Id
	 */
	public function checkProductId() {
		if (empty($this->product_id)) {
			$this->addError('product_id', '商品Id必须传递');
		} elseif (!Product::instance()->existsByPrimaryKey($this->product_id)) {
			$this->addError('product_id', '对应的商品不存在');
		}
	}
}