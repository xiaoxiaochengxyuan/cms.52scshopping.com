<?php
namespace app\base;
use yii\db\Query;
use yii\db\Connection;

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
	public static function instance(string $className) {
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
	protected function primaryKey() : string {
		return 'id';
	}
	
	/**
	 * 返回表名
	 * @return string
	 */
	protected abstract function tableName():string;
	
	/**
	 * 获取一个数据查询构造器
	 * @return Query
	 */
	public function createQuery() : Query {
		return new Query();
	}
	
	/**
	 * 获取数据库连接
	 * @return Connection
	 */
	public static function db() : Connection {
		return \Yii::$app->db;
	}
	
	/**
	 * 获取对应表所有的列
	 * @return array
	 */
	protected function columns() : array {
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
	protected function hasColumn(string $columnName) : bool {
		return in_array($columnName, $this->columns());
	}
	
	/**
	 * 是否存在create_time列
	 * @return bool
	 */
	protected function hasCreateTimeColumn() : bool {
		return $this->hasColumn('create_time');
	}
	
	/**
	 * 是否有update_time列
	 * @return bool
	 */
	protected function hasUpdateTimeColumn() : bool {
		return $this->hasColumn('update_time');
	}
	
	/**
	 * 添加数据
	 * @param array $data
	 * @return int 影响的行数
	 */
	public function insert(array $data) : int {
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
	public function update(int $id, array $data) : int {
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
	 * 删除一条数据
	 * @param int $id 要删除的数据的Id
	 * @return int 影响的行数
	 */
	public function delete(int $id) : int {
		return self::db()->createCommand()->delete($this->tableName(), "{$this->primaryKey()}=:id", [':id' => $id])->execute();
	}
	
	/**
	 * 通过Id获取一行数据
	 * @param int $id 要获取数据的Id
	 * @param string $select 要查询的字段
	 * @return array
	 */
	public function get(int $id, $select = '*') : array {
		return $this->createQuery()
			->select($select)
			->from($this->tableName())
			->where("{$this->primaryKey()}=:id", [':id' => $id])
			->one();
	}
	
	
	/**
	 * 通过字段获取一行数据
	 * @param string $columnName 字段名称
	 * @param string $columnValue 字段值
	 * @param string $select 要查询的字段
	 * @return array
	 */
	public function getByColumn(string $columnName, string $columnValue, $select = '*') : array {
		return $this->createQuery()
			->select($select)
			->from($this->tableName())
			->where("{$columnName}=:{$columnName}", [":{$columnName}" => $columnValue])
			->one();
	}
}