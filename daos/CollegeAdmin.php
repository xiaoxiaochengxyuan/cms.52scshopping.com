<?php
namespace app\daos;
use app\base\BaseDao;
use app\utils\StringUtil;
use Codeception\Lib\Connector\Yii1;
/**
 * 大学管理员Dao
 * @author xiawei
 */
class CollegeAdmin extends BaseDao {
	/**
	 * 表名
	 * @var string
	 */
	const TABLE_NAME = 'college_admin';
	
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
	 * @return CollegeAdmin
	 */
	public static function instance($className = __CLASS__) {
		return parent::instance($className);
	}
	
	/**
	 * {@inheritDoc}
	 * @see \app\base\BaseDao::insert()
	 */
	public function insert($data) {
		if (!isset($data['salt'])) {
			$data['salt'] = \Yii::$app->getSecurity()->generateRandomString(8);
		}
		if (!isset($data['password'])) {
			$data['password'] = '0123456789';
		}
		$data['password'] = StringUtil::genPassword($data['password'], $data['salt']);
		return parent::insert($data);
	}
	
	/**
	 * 重置密码
	 * @param int $id
	 * @return int
	 */
	public function resetPassword($id) {
		$salt = \Yii::$app->getSecurity()->generateRandomString(8);
		$password = '0123456789';
		$data = [
			'password' => StringUtil::genPassword($password, $salt),
			'salt' => $salt
		];
		return parent::update($id, $data);
	}
}