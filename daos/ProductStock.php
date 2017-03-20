<?php
namespace app\daos;
use app\base\Dao;
/**
 * 商品库存表
 * @author xiawei
 */
class ProductStock extends Dao {
	/**
	 * 表名
	 * @var string
	 */
	const TABLE_NAME = 'product_stock';
	
	/**
	 * {@inheritDoc}
	 * @see \app\base\Dao::tableName()
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
	
	/**
	 * 获取列表页数据
	 * @param int $productId
	 * @return array
	 */
	public function indexList($productId) {
		return $this->createQuery()
			->select(['ps.id', 'ps.name', 'ps.num', 'ps.warning_num', 'ps.stock_price', 'ps.price', 'p.name as product_name'])
			->from($this->tableName().' ps')
			->leftJoin(Product::TABLE_NAME.' p', 'p.id=ps.product_id')
			->where("p.id={$productId}")
			->all(self::db());
	}
	
	/**
	 * {@inheritDoc}
	 * @see \app\base\Dao::insert()
	 */
	public function insert($data) {
		//首先查看对应商品是否启用选项库存
		$isOptionNum = Product::instance()->scalarByPrimaryKey($data['product_id'], 'is_option_num');
		//如果没有启用那么开启事务
		if ($isOptionNum == 0) {
			$transaction = self::db()->beginTransaction();
		}
		//添加选项库存
		$num = parent::insert($data);
		if ($num) {
			if ($isOptionNum == 0) {
				if (Product::instance()->update($data['product_id'], ['is_option_num' => 1])) {
					$transaction->commit();
				} else {
					$transaction->rollBack();
				}
				return $num;
			}
		}
		if ($isOptionNum == 0) {
			$transaction->rollBack();
		}
		return $num;
	}
	
	/**
	 * {@inheritDoc}
	 * @see \app\base\Dao::delete()
	 */
	public function delete($id) {
		$productId = $this->scalarByPrimaryKey($id, 'product_id');
		//判断当前选项库存是不是最后一个
		$count = $this->countByColumn('product_id', $productId);
		if ($count > 1) {
			return parent::delete($id);
		} else {
			$transaction = self::db()->beginTransaction();
			if (Product::instance()->update($productId, ['is_option_num' => 0])) {
				$result = parent::delete($id);
				if ($result) {
					$transaction->commit();
					return $result;
				}
			}
			$transaction->rollBack();
		}
		return false;
	}
}