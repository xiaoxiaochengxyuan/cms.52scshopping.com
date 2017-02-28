<?php
namespace app\daos;
use app\base\BaseDao;
/**
 * 对应的区域Dao
 * @author xiawei
 */
class Region extends BaseDao {
	/**
	 * 表名
	 * @var string
	 */
	const TALBE_NAME = 'region';
	/**
	 * {@inheritDoc}
	 * @see \app\base\BaseDao::tableName()
	 */
	protected function tableName() {
		return self::TALBE_NAME;
	}
	
	/**
	 * 单例
	 * @param string $className
	 * @return Region
	 */
	public static function instance(string $className = __CLASS__) {
		return parent::instance($className);
	}
	
	/**
	 * 获取省的下拉列表数据
	 * @return array
	 */
	public function provinceDroplistData() {
		$provinces = $this->listByColumn('pid', 1, ['id', 'name']);
		$result = [];
		foreach ($provinces as $province) {
			$result[$province['id']] = $province['name'];
		}
		return $result;
	}
	
	/**
	 * 获取城市或者区县下拉数据
	 * @param int $provinceId
	 * @return array
	 */
	public function droplistData($provinceId) {
		$data = $this->listByColumn('pid', $provinceId, ['id', 'name']);
		$result = [];
		if ($provinceId == 0) {
			return $result;
		}
		foreach ($data as $d) {
			$result[$d['id']] = $d['name'];
		}
		return $result;
	}
}