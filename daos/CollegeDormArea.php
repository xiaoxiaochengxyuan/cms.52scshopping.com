<?php
namespace app\daos;
use app\base\Dao;

/**
 * 大学宿舍区域
 * @author xiawei
 */
class CollegeDormArea extends Dao {
	/**
	 * 对应的表名
	 * @var string
	 */
	const TABLE_NAME = 'college_dorm_area';
	
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
	 * @return CollegeDormArea
	 */
	public static function instance($className = __CLASS__) {
		return parent::instance($className);
	}
	
	/**
	 * 获取大学宿舍区域首页数据
	 * @param int $collegeId 对应的大学Id
	 * @return array
	 */
	public function indexData($collegeId) {
		return $this->createQuery()
			->select(['c.name as college_name', 'cda.id', 'cda.name', 'cda.create_time', 'cda.update_time'])
			->from($this->tableName().' cda')
			->leftJoin(College::TABLE_NAME.' c', 'c.id=cda.college_id')
			->all(self::db());
	}
}