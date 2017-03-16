<?php
namespace app\daos;
use app\base\Dao;
/**
 * 商品分类
 * @author xiawei
 */
class ProductCat extends Dao {
	/**
	 * 表名
	 * @var string
	 */
	const TABLE_NAME = 'product_cat';
	
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
	 * @return ProductCat
	 */
	public static function instance($className = __CLASS__) {
		return parent::instance($className);
	}
	
	
	/**
	 * 通过条件列和pid来判断对应的数据收存在
	 * @param string $columnName
	 * @param string $columnValue
	 * @param int $pid
	 * @return boolean
	 */
	public function existsByColumnAndPid($columnName, $columnValue, $pid) {
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
	public function getIndexData($pid) {
		return $this->createQuery()
			->select(['pc.id', 'pc.name', 'pc.en_name', 'ppc.name as ppc_name', 'pc.icon', 'pc.pid', 'pc.icon_bgcolor'])
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
	public function dropListData($pid) {
		$productCats = $this->createQuery()
			->select(['id', 'name'])
			->from($this->tableName())
			->where('pid=:pid', [':pid' => $pid])
			->all(self::db());
		if (empty($productCats)) {
			return ['--请选择--'];
		}
		return array_column($productCats, 'name', 'id');
	}
	
	/**
	 * 通过条件列和pid判断主键不为id的值是否存在
	 * @param string $columnName 条件列名
	 * @param string $columnValue 条件列值
	 * @param int $pid 对应的父id
	 * @param int $id 对应的id
	 * @return bool 存在返回true,否则返回false
	 */
	public function existsColumnAndPidWithoutId($columnName, $columnValue, $pid, $id) {
		return $this->createQuery()
			->from($this->tableName())
			->where("{$columnName}=:{$columnName} and pid=:pid and id<>:id", [":{$columnName}" => $columnValue, ':pid' => $pid, ':id' => $id])
			->exists(self::db());
	}
}