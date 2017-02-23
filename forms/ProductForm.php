<?php
namespace app\forms;
use yii\base\Model;
/**
 * 商品表单
 * @author xiawei
 */
class ProductForm extends Model {
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
	 * 初始的商品库存
	 * @var integer
	 */
	public $number = 0;
	
	
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
	 * 产地
	 * @var string
	 */
	public $create_place = null;
	
	
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
}