<?php
namespace app\forms;
use yii\base\Model;
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
}