<?php
namespace app\daos;
use app\base\BaseDao;
/**
 * 商品分类
 * @author xiawei
 */
class ProductCat extends BaseDao {
	/**
	 * 表名
	 * @var string
	 */
	const TABLE_NAME = 'product_cat';
	
	/**
	 * {@inheritDoc}
	 * @see \app\base\BaseDao::tableName()
	 */
	protected function tableName() : string {
		return self::TABLE_NAME;
	}
	
	/**
	 * 单例
	 * @param string $className
	 * @return ProductCat
	 */
	public static function instance(string $className = __CLASS__) {
		return parent::instance($className);
	}
	
	
	/**
	 * 通过条件列和pid来判断对应的数据收存在
	 * @param string $columnName
	 * @param string $columnValue
	 * @param int $pid
	 * @return boolean
	 */
	public function existsByColumnAndPid(string $columnName, string $columnValue, int $pid) {
		return $this->createQuery()
			->from($this->tableName())
			->where("{$columnName}=:{$columnName} and pid=:pid", [":{$columnName}" => $columnValue, ':pid' => $pid])
			->exists(self::db());
	}
	
	
	/**
	 * 获取首页数据
	 * @param integer $pid 对应的父Id
	 * @return array
	 */
	public function getIndexData(int $pid) : array {
		return $this->createQuery()
			->select(['pc.id', 'pc.name', 'pc.en_name', 'ppc.name as ppc_name'])
			->from($this->tableName().' pc')
			->leftJoin($this->tableName().' ppc', 'pc.pid=ppc.id')
			->where('pc.pid=:pid', [':pid' => $pid])
			->orderBy(['pc.update_time' => SORT_DESC])
			->all(self::db());
	}
	
	/**
	 * 获取商品类型下拉列表数据
	 * @param int $pid 对应的父级id
	 * @return array
	 */
	public function dropListData(int $pid) : array {
		$productCats = $this->createQuery()
			->select(['id', 'name'])
			->from($this->tableName())
			->where('pid=:pid', [':pid' => $pid])
			->all();
		return array_column($productCats, 'name', 'id');
	}
}