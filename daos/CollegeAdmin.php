<?php
namespace app\daos;
use app\utils\StringUtil;
use app\base\Dao;
/**
 * 大学管理员Dao
 * @author xiawei
 */
class CollegeAdmin extends Dao {
	/**
	 * 表名
	 * @var string
	 */
	const TABLE_NAME = 'college_admin';
	
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
	 * @return CollegeAdmin
	 */
	public static function instance($className = __CLASS__) {
		return parent::instance($className);
	}
	
	/**
	 * {@inheritDoc}
	 * @see \app\base\Dao::insert()
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