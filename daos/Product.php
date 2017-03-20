<?php
namespace app\daos;
use yii\data\Pagination;
use app\base\Dao;
/**
 * 商品对应的Dao
 * @author xiawei
 */
class Product extends Dao {
	/**
	 * 表名
	 * @var string
	 */
	const TABLE_NAME = 'product';
	
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
	 * @return Product
	 */
	public static function instance($className = __CLASS__) {
		return parent::instance($className);
	}
	
	/**
	 * 通过查询条件获取对应的数据总数
	 * @param array $search 查询条件
	 * @return int
	 */
	public function countBySearch(array $search) {
		$condition = ['and'];
		if (!empty($search['name'])) {
			$condition[] = ['like', 'name', $search['name']];
		}
		if ($search['grounding'] != -1) {
			$condition[] = "grounding={$search['grounding']}";
		}
		if ($search['stock_price_min'] !== '') {
			$condition[] = "stock_price_min>={$search['stock_price_min']}";
		}
		if ($search['stock_price_max'] !== '') {
			$condition[] = "stock_price_max<={$search['stock_price_max']}";
		}
		if ($search['top_cat_id'] !== '') {
			$condition[] = "top_cat_id={$search['top_cat_id']}";
		}
		if ($search['cat_id'] !== '') {
			$condition[] = "cat_id={$search['cat_id']}";
		}
		
		return $this->createQuery()
			->from($this->tableName())
			->where($condition)
			->count('*', self::db());
	}
	
	/**
	 * 根据搜索条件分页查询数据
	 * @param array $search 搜索条件
	 * @param Pagination $pagination 分页组件
	 * @param string $select 查询字段
	 * @return array 返回数据 
	 */
	public function pageBySearch($search, Pagination $pagination) {
		$condition = ['and'];
		if (!empty($search['name'])) {
			$condition[] = ['like', 'p.name', $search['name']];
		}
		if ($search['grounding'] != -1) {
			$condition[] = "p.grounding={$search['grounding']}";
		}
		if ($search['stock_price_min'] !== '') {
			$condition[] = "p.stock_price_min>={$search['stock_price_min']}";
		}
		if ($search['stock_price_max'] !== '') {
			$condition[] = "p.stock_price_max<={$search['stock_price_max']}";
		}
		if ($search['top_cat_id'] != 0) {
			$condition[] = "p.top_cat_id={$search['top_cat_id']}";
		}
		if ($search['cat_id'] != 0) {
			$condition[] = "p.cat_id={$search['cat_id']}";
		}
		$select = [
			'p.id',
			'p.name',
			'p.stock_price',
			'p.price',
			'p.title_img',
			'p.show_buy_number',
			'p.grounding',
			'tpc.name as tpc_name',
			'pc.name as pc_name',
			'p.is_options_num',
			'p.num',
			'p.is_jinpin'
		];
		return $this->createQuery()
			->select($select)
			->from($this->tableName().' p')
			->leftJoin(ProductCat::TABLE_NAME.' tpc', 'tpc.id=p.top_cat_id')
			->leftJoin(ProductCat::TABLE_NAME.' pc', 'pc.id=p.cat_id')
			->where($condition)
			->offset($pagination->getOffset())
			->limit($pagination->getLimit())
			->all(self::db());
	}
	
	
	/**
	 * {@inheritDoc}
	 * @see \app\base\Dao::delete()
	 */
	public function delete($id) {
		//首先获取产品的选项
		$options = $this->scalarByPrimaryKey($id, 'options');
		if (empty($options)) {
			return $this->delete($id);
		} else {
			$transaction = self::db()->beginTransaction();
			if ($this->delete($id) && (ProductStock::instance()->deleteByColumn('product_id', $id) !== false)) {
				$transaction->commit();
				return true;
			}
			$transaction->rollBack();
			return false;
		}
	}
	
	
	/**
	 * 获取商品库存
	 * @param int $id 对应的商品Id
	 * @return mixed|mixed|number|boolean|string
	 */
	public function getProductNum($id) {
		//获取对应的商品选项
		$product = $this->get($id, ['options', 'number']);
		if (empty($product['options'])) {
			return $product['number'];
		}
		return ProductStock::instance()->sumByColumn('product_id', $id, 'num');
	}
}