<?php
namespace app\daos;
use app\base\BaseDao;
/**
 * 商品库存表
 * @author xiawei
 */
class ProductStock extends BaseDao {
	/**
	 * 表名
	 * @var string
	 */
	const TABLE_NAME = 'product_stock';
	
	/**
	 * {@inheritDoc}
	 * @see \app\base\BaseDao::tableName()
	 */
	protected function tableName() {
		return self::TABLE_NAME;
	}
	
	/**
	 * 单例
	 * @param string $className
	 * @return ProductStock
	 */
	public static function instance($className = __CLASS__) {
		return parent::instance($className);
	}
	
	/**
	 * 增加库存
	 * @param int $id 对应商品库存的id
	 * @param int $num 要增加多少个库存
	 * @return number 影响的行数
	 */
	public function plusNum($id, $num) {
		$sql = "update {$this->tableName()} set num=num+{$num} where id={$id}";
		return self::db()->createCommand($sql)->execute();
	}
}