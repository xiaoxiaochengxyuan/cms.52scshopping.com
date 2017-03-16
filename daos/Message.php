<?php
namespace app\daos;
use yii\data\Pagination;
use app\base\Dao;
/**
 * 消息对应的Dao
 * @author xiawei
 */
class Message extends Dao {
	/**
	 * 表名
	 * @var string
	 */
	const TABLE_NAME = 'message';
	
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
	 * @return Message
	 */
	public static function instance($className = __CLASS__) {
		return parent::instance($className);
	}
	
	/**
	 * 通过搜索条件获取对应的总数
	 * @param array $search 查询条件
	 * @return number 总数
	 */
	public function countBySearch(array $search) {
		$condition = [];
		return $this->count();
	}
	
	
	/**
	 * 分页查询数据
	 * @param Pagination $pagination 分页组件
	 * @param array $search 查询条件
	 * @return array
	 */
	public function pageBySearch(Pagination $pagination, array $search) {
		$condition = [];
		return $this->createQuery()
			->select(['m.id', 'm.title', 'm.desc', 'm.keywords', 'm.enable', 'c.name as college_name'])
			->from($this->tableName().' m')
			->leftJoin(College::TABLE_NAME.' c', 'c.id=m.college_id')
			->where($condition)
			->offset($pagination->getOffset())
			->limit($pagination->getLimit())
			->all(self::db());
	}
}