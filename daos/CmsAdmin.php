<?php
namespace app\daos;
use app\base\BaseDao;
use app\utils\StringUtil;
/**
 * 内容管理系统管理员
 * @author xiawei
 */
class CmsAdmin extends BaseDao {
	/**
	 * 表名
	 * @var string
	 */
	const TABLE_NAME = 'cms_admin';
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
	 * @return CmsAdmin
	 */
	public static function instance(string $className = __CLASS__) {
		return parent::instance($className);
	}
	
	/**
	 * {@inheritDoc}
	 * @see \app\base\BaseDao::insert()
	 */
	public function insert(array $data) : int {
		//首先生成随机数加密盐
		if (!isset($data['salt'])) {
			$data['salt'] = \Yii::$app->getSecurity()->generateRandomString(8);
		}
		$data['password'] = StringUtil::genPassword($data['password'], $data['salt']);
		return parent::insert($data);
	}
}