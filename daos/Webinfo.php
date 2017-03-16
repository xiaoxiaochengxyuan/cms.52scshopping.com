<?php
namespace app\daos;
use app\base\Dao;
/**
 * 网站基本信息
 * @author xiawei
 */
class Webinfo extends Dao {
	/**
	 * 表名
	 * @var string
	 */
	const TABLE_NAME = 'webinfo';
	
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
	 * @return Webinfo
	 */
	public static function instance($className = __CLASS__) {
		return parent::instance($className);
	}
	
	/**
	 * 获取网站基本信息
	 * @param string $field
	 * @return boolean|array
	 */
	public function getWebinfo($field = '*') {
		return $this->createQuery()
			->select($field)
			->from($this->tableName())
			->one(self::db());
	}
	
	/**
	 * 判断网站基本信息是否存在
	 * @return boolean
	 */
	public function exists() {
		return $this->createQuery()
			->from($this->tableName())
			->exists(self::db());
	}
	
	/**
	 * 编辑网站基本信息
	 * @param array $data
	 * @return number|unknown
	 */
	public function edit($data) {
		if (!$this->exists()) {
			return parent::insert($data);
		}
		return parent::updateAll($data);
	}
}