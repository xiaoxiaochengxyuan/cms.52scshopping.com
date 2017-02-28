<?php
namespace app\daos;
use app\base\BaseDao;
use yii\data\Pagination;
/**
 * 商品对应的Dao
 * @author xiawei
 */
class Product extends BaseDao {
	/**
	 * 表名
	 * @var string
	 */
	const TABLE_NAME = 'product';
	
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
		return $this->createQuery()
			->select(['p.id', 'p.name', 'p.stock_price', 'p.price', 'p.number', 'p.create_place', 'p.title_img', 'p.warn_number', 'p.show_buy_number', 'p.grounding', 'tpc.name as tpc_name', 'pc.name as pc_name'])
			->from($this->tableName().' p')
			->leftJoin(ProductCat::TABLE_NAME.' tpc', 'tpc.id=p.top_cat_id')
			->leftJoin(ProductCat::TABLE_NAME.' pc', 'pc.id=p.cat_id')
			->where($condition)
			->offset($pagination->getOffset())
			->limit($pagination->getLimit())
			->all(self::db());
	}
}