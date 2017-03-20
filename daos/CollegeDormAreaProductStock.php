<?php
namespace app\daos;
use app\base\Dao;
/**
 * 大学区域商品库存
 * @author xiawei
 */
class CollegeDormAreaProductStock extends Dao {
	/**
	 * 表名
	 * @var string
	 */
	const TABLE_NAME = 'college_dorm_area_product_stock';
	
	/**
	 * {@inheritDoc}
	 * @see \app\base\Dao::tableName()
	 */
	protected function tableName() {
		return self::TABLE_NAME;
	}
	
	/**
	 * 单例
	 * @param system $className
	 * @return CollegeDormAreaProductStock
	 */
	public static function instance($className = __CLASS__) {
		return parent::instance($className);
	}
}