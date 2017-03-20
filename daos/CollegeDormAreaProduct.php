<?php
namespace app\daos;
use app\base\Dao;
/**
 * 大学区域商品
 * @author xiawei
 */
class CollegeDormAreaProduct extends Dao {
	/**
	 * 表名
	 * @var string
	 */
	const TABLE_NAME = 'college_dorm_area_product';
	
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
	 * @return CollegeDormAreaProduct
	 */
	public static function instance($className = __CLASS__) {
		return parent::instance($className);
	}
}