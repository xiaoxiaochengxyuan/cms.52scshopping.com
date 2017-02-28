<?php
namespace app\base;
use yii\db\Query;
use yii\db\Connection;
use yii\data\Pagination;

/**
 * 所有Dao的基类
 * @author xiawei
 */
abstract class BaseDao {
	/**
	 * 对应的列
	 * @var []
	 */
	private $columns = null;
	
	/**
	 * 所有的实例容器
	 * @var array
	 */
	private static $INSTANCES = [];
	
	/**
	 * 单例
	 * @param string $className
	 * @return BaseDao
	 */
	public static function instance($className) {
		if (isset(self::$INSTANCES[$className])) {
			return self::$INSTANCES[$className];
		}
		$reflectionClass = new \ReflectionClass($className);
		$instance = $reflectionClass->newInstanceWithoutConstructor();
		self::$INSTANCES[$className] = $instance;
		return $instance;
	}
	
	/**
	 * 获取主键名称
	 * @return string
	 */
	protected function primaryKey() {
		return 'id';
	}
	
	/**
	 * 返回表名
	 * @return string
	 */
	protected abstract function tableName();
	
	/**
	 * 获取一个数据查询构造器
	 * @return Query
	 */
	public function createQuery() {
		return new Query();
	}
	
	/**
	 * 获取数据库连接
	 * @return Connection
	 */
	public static function db() {
		return \Yii::$app->db;
	}
	
	/**
	 * 获取对应表所有的列
	 * @return array
	 */
	protected function columns() {
		if (empty($this->columns)) {
			$this->columns = self::db()->getSchema()->getTableSchema($this->tableName())->getColumnNames();
		}
		return $this->columns;
	}
	
	/**
	 * 判断表中是否存在某个列
	 * @param string $columnName 对应的列名
	 * @return bool
	 */
	protected function hasColumn($columnName) {
		return in_array($columnName, $this->columns());
	}
	
	/**
	 * 是否存在create_time列
	 * @return bool
	 */
	protected function hasCreateTimeColumn() {
		return $this->hasColumn('create_time');
	}
	
	/**
	 * 是否有update_time列
	 * @return bool
	 */
	protected function hasUpdateTimeColumn() {
		return $this->hasColumn('update_time');
	}
	
	/**
	 * 添加数据
	 * @param array $data
	 * @return int 影响的行数
	 */
	public function insert($data) {
		if (isset($data[$this->primaryKey()])) {
			unset($data[$this->primaryKey()]);
		}
		$nowTime = time();
		if ($this->hasCreateTimeColumn()) {
			$data['create_time'] = $nowTime;
		}
		if ($this->hasUpdateTimeColumn()) {
			$data['update_time'] = $nowTime;
		}
		return self::db()->createCommand()->insert($this->tableName(), $data)->execute();
	}
	
	/**
	 * 根据Id修改一条数据
	 * @param int $id 要修改的数据的主键
	 * @param array $data 要修改的数据
	 * @return int
	 */
	public function update($id, $data) {
		if (isset($data[$this->primaryKey()])) {
			unset($data[$this->primaryKey()]);
		}
		$nowTime = time();
		if ($this->hasUpdateTimeColumn()) {
			$data['update_time'] = $nowTime;
		}
		return self::db()->createCommand()->update($this->tableName(), $data, "{$this->primaryKey()}=:id", [':id' => $id])->execute();
	}
	
	/**
	 * 修改全表数据
	 * @param array $data 要修改的数据
	 * @return number
	 */
	public function updateAll($data) {
		return self::db()->createCommand()->update($this->tableName(), $data)->execute();
	}
	
	/**
	 * 删除一条数据
	 * @param int $id 要删除的数据的Id
	 * @return int 影响的行数
	 */
	public function delete($id) {
		return self::db()->createCommand()->delete($this->tableName(), "{$this->primaryKey()}=:id", [':id' => $id])->execute();
	}
	
	/**
	 * 通过Id获取一行数据
	 * @param int $id 要获取数据的Id
	 * @param string $select 要查询的字段
	 * @return array
	 */
	public function get($id, $select = '*') {
		return $this->createQuery()
			->select($select)
			->from($this->tableName())
			->where("{$this->primaryKey()}=:id", [':id' => $id])
			->one(self::db());
	}
	
	
	/**
	 * 通过字段获取一行数据
	 * @param string $columnName 字段名称
	 * @param string $columnValue 字段值
	 * @param string $select 要查询的字段
	 * @return array
	 */
	public function getByColumn($columnName, $columnValue, $select = '*') {
		return $this->createQuery()
			->select($select)
			->from($this->tableName())
			->where("{$columnName}=:{$columnName}", [":{$columnName}" => $columnValue])
			->one(self::db());
	}
	
	/**
	 * 删除表中所有的数据,慎用
	 * @return int 影响的行数
	 */
	public function deleteAll() {
		return self::db()->createCommand()->delete($this->tableName())->execute();
	}
	
	/**
	 * 获取所有数据
	 * @param string $select 要查询的数据列
	 * @return array 返回的数据
	 */
	public function listAll($select = '*') {
		return $this->createQuery()->select($select)->from($this->tableName())->all(self::db());
	}
	
	/**
	 * 通过某一列获取对应的数据
	 * @param string $columnName 对应的列名
	 * @param string $columnValue 对应的值
	 * @param unknown $select 要查询的数据
	 * @return array
	 */
	public function listByColumn($columnName, $columnValue, $select = '*') {
		return $this->createQuery()->select($select)->from($this->tableName())->where("{$columnName}=:{$columnName}", [":{$columnName}" => $columnValue])->all(self::db());
	}
	
	/**
	 * 通过某一列获取对应的数据
	 * @param string $columnName 对应的列名
	 * @param string $columnValue 对应的值
	 * @param unknow $select 要查询的列
	 * @return array
	 */
	public function colomnByColumn($columnName, $columnValue, $select) {
		return $this->createQuery()->select($select)->from($this->tableName())->where("{$columnName}=:{$columnName}", [":{$columnName}" => $columnValue])->column(self::db());
	}
	
	/**
	 * 通过列名和列值来判断对应值是否存在
	 * @param string $columnName 对应的列名
	 * @param string $columnValue 对应的列值
	 * @return boolean true表示成功,false表示失败
	 */
	public function existsByColumn($columnName, $columnValue) {
		return $this->createQuery()->from($this->tableName())->where("{$columnName}=:{$columnName}", [":{$columnName}" => $columnValue])->exists(self::db());
	}
	
	
	/**
	 * 分页获取数据
	 * @param Pagination $pagination 对应分页
	 * @param string $select 要查询的数据
	 * @return array
	 */
	public function listByPage(Pagination $pagination, $select = '*') {
		return $this->createQuery()
			->select($select)
			->from($this->tableName())
			->offset($pagination->getOffset())
			->limit($pagination->getLimit())
			->all(self::db());
	}
	
	/**
	 * 获取总数
	 * @return int
	 */
	public function count() {
		return $this->createQuery()
			->from($this->tableName())
			->count('*', self::db());
	}
	
	/**
	 * 通过对应的列分页获取数据
	 * @param Pagination $pagination 分页组件
	 * @param string $columnName 对应的列名称
	 * @param string $columnValue 对应的列值
	 * @param string $select 要查询的字段
	 * @return array 返回的数据
	 */
	public function pageByColumn(Pagination $pagination, $columnName, $columnValue, $select = '*') {
		return $this->createQuery()
			->select($select)
			->from($this->tableName())
			->where("{$columnName}=:{$columnName}", [":{$columnName}" => $columnValue])
			->offset($pagination->getOffset())
			->limit($pagination->getLimit())
			->all(self::db());
	}
	
	/**
	 * 获取总数
	 * @param string $columnName 对应的列名
	 * @param string $columnValue 对应的列值
	 * @return int
	 */
	public function countByColumn($columnName, $columnValue) {
		return $this->createQuery()
			->from($this->tableName())
			->where("{$columnName}=:{$columnName}", [":{$columnName}" => $columnValue])
			->count('*', self::db());
	}
	
	/**
	 * 通过条件列判断主键不是$id的数据是否存在
	 * @param string $columnName 对应列名
	 * @param string $columnValue 对应列值
	 * @param int $id 对应的主键
	 * @return bool 存在返回true,否则返回FALSE
	 */
	public function existsColumnWithoutPrimarykey($columnName, $columnValue, $id) {
		return $this->createQuery()
			->from($this->tableName())
			->where("{$columnName}=:{$columnName} and {$this->primaryKey()}<>:{$this->primaryKey()}", [":{$columnName}" => $columnValue, ":{$this->primaryKey()}" => $id])
			->exists(self::db());
	}
	
	/**
	 * 通过条件列删除数据
	 * @param string $columnName
	 * @param string $columnValue
	 * @return number
	 */
	public function deleteByColumn(string $columnName, string $columnValue) {
		return self::db()->createCommand()->delete($this->tableName(), "{$columnName}=:{$columnName}", [":{$columnName}" => $columnValue])->execute();
	}
	
	/**
	 * 通过主键检查数据是否存在
	 * @param int $id 对应的主键
	 * @return boolean 存在返回true,否则返回FALSE
	 */
	public function existsByPrimaryKey($id) {
		return $this->existsByColumn($this->primaryKey(), $id);
	}
	
	/**
	 * 通过条件列和值来获取对应的数据
	 * @param string $columnName 条件列名
	 * @param string $columnValue 条件列值
	 * @param string $select 要获取的数据
	 * @return string|NULL|\yii\db\false
	 */
	public function scalarByColumn($columnName, $columnValue, $select) {
		return $this->createQuery()
			->select($select)
			->from($this->tableName())
			->where("{$columnName}=:{$columnName}", [":{$columnName}" => $columnValue])
			->scalar(self::db());
	}
	
	/**
	 * 通过主键获取对应数据
	 * @param integer $id 对应主键
	 * @param integer $select 要查询的字段
	 * @return string|NULL|\yii\db\false
	 */
	public function scalarByPrimaryKey($id, $select) {
		return $this->createQuery()
			->select($select)
			->from($this->tableName())
			->where("{$this->primaryKey()}=:{$this->primaryKey()}", [":{$this->primaryKey()}" => $id])
			->scalar(self::db());
	}
}