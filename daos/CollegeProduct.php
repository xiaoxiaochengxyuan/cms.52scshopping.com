<?php
namespace app\daos;
use app\base\Dao;

/**
 * 大学商品Dao
 * @author xiawei
 */
class CollegeProduct extends Dao {
	/**
	 * 表名
	 * @var string
	 */
	const TABLE_NAME = 'college_product';
	
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
	 * @return CollegeProduct
	 */
	public static function instance($className = __CLASS__) {
		return parent::instance($className);
	}
}