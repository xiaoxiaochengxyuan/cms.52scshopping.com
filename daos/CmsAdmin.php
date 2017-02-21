<?php
namespace app\daos;
use app\base\BaseDao;
use app\utils\StringUtil;
use yii\helpers\Json;
use yii\web\Cookie;
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
	
	const CMS_ADMIN_COOKIE_KEY = 'cms_admin_cookie_key';
	
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
		$salt = \Yii::$app->getSecurity()->generateRandomString(8);
		$insertData = [
			'username' => $data['username'],
			'salt' => $salt,
			'password' => StringUtil::genPassword($data['password'], $salt),
		];
		return parent::insert($insertData);
	}
	
	/**
	 * 用户登录
	 * @param array $data
	 */
	public static function login(array $data) : void {
		if (isset($data['password'])) {
			unset($data['password']);
		}
		if (isset($data['salt'])) {
			unset($data['salt']);
		}
		$loginJsonStr = Json::encode($data);
		$loginCookieStr = StringUtil::encryStr($loginJsonStr);
		$cookie = new Cookie(['name' => self::CMS_ADMIN_COOKIE_KEY, 'value' => $loginCookieStr]);
		\Yii::$app->response->cookies->add($cookie);
	}
	
	/**
	 * 判断用户是否登录
	 * @return bool
	 */
	public static function isLogin() : bool {
		try {
			$loginCookieStr = \Yii::$app->request->cookies->getValue(self::CMS_ADMIN_COOKIE_KEY);
			$loginJsonStr = StringUtil::decryStr($loginCookieStr);
			$cmsAdmin = Json::decode($loginJsonStr);
			if (isset($cmsAdmin['id'])) {
				return true;
			}
			return false;
		} catch (\Exception $e) {
			return false;
		}
	}
	
	/**
	 * 获取用户的登录信息
	 * @param string $field 对应的字段
	 * @return mixed|NULL|NULL
	 */
	public static function loginInfo(string $field = null) {
		if (self::isLogin()) {
			$loginCookieStr = \Yii::$app->request->cookies->getValue(self::CMS_ADMIN_COOKIE_KEY);
			$loginJsonStr = StringUtil::decryStr($loginCookieStr);
			$cmsAdmin = Json::decode($loginJsonStr);
			if (empty($field)) {
				return $cmsAdmin;
			}
			return isset($cmsAdmin[$field]) ? $cmsAdmin[$field] : null;
		}
		return null;
	}
	
	/**
	 * 用户退出登录
	 */
	public static function logout() : void {
		\Yii::$app->response->cookies->remove(self::CMS_ADMIN_COOKIE_KEY);
	}
	
	/**
	 * 修改密码
	 * @param integer $id
	 * @param string $password
	 * @return int 影响的行数
	 */
	public function changePasswd(int $id, string $password) : int {
		$salt = \Yii::$app->getSecurity()->generateRandomString(8);
		$data = [
			'salt' => $salt,
			'password' => StringUtil::genPassword($password, $salt),
		];
		return parent::update($id, $data);
	}
	
	/**
	 * 判断一个用户是否具有权限操作某个模块
	 * @param string $controllerId 对应的Controller的Id
	 * @param string $actionId 对应的Action的Id
	 * @return boolean 有权限返回true,否则返回false
	 */
	public static function hasPremiss(string $controllerId, string $actionId) : bool {
		$auth = \Yii::$app->params['auth'];
		//如果需要权限验证
		if (isset($auth[$controllerId]) && (isset($auth[$controllerId]['*']) || isset($auth[$controllerId][$actionId]))) {
			$level = isset($auth[$controllerId]['*']) ? $auth[$controllerId]['*'] : $auth[$controllerId][$actionId];
			$currentLoginLevel = CmsAdmin::loginInfo('level');
			if ($level != $currentLoginLevel) {
				return false;
			}
		}
		return true;
	}
}