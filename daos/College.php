<?php
namespace app\daos;
use app\base\BaseDao;
use yii\data\Pagination;
/**
 * 大学对应的Dao
 * @author xiawei
 */
class College extends BaseDao {
	/**
	 * 表名
	 * @var string
	 */
	const TABLE_NAME = 'college';
	
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
	 * @return College
	 */
	public static function instance(string $className = __CLASS__) {
		return parent::instance($className);
	}
	
	/**
	 * 分页获取对应的大学
	 * @param Pagination $pagination
	 * @return array
	 */
	public function pageColleges(Pagination $pagination) : array {
		return $this->createQuery()
			->select(['c.id', 'c.name', 'c.detail_address', 'r1.name as province_name', 'r2.name as city_name', 'r3.name as region_name'])
			->from($this->tableName().' c')
			->leftJoin(Region::TALBE_NAME.' r1', 'r1.id=c.province_id')
			->leftJoin(Region::TALBE_NAME.' r2', 'r2.id=c.city_id')
			->leftJoin(Region::TALBE_NAME.' r3', 'r3.id=c.region_id')
			->offset($pagination->getOffset())
			->limit($pagination->getLimit())
			->all($this->db());
	}
}