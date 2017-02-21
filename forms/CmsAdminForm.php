<?php
namespace app\forms;
use yii\base\Model;
use app\utils\VerifyUtil;
use app\daos\CmsAdmin;
use app\utils\StringUtil;
/**
 * Cms管理员相关的Form表单
 * @author xiawei
 */
class CmsAdminForm extends Model {
	/**
	 * 用户名
	 * @var string
	 */
	public $username = null;
	
	/**
	 * 密码
	 * @var string
	 */
	public $password = null;
	
	
	/**
	 * 验证码
	 * @var string
	 */
	public $verifyCode = null;
	
	/**
	 * 就密码
	 * @var string
	 */
	public $oldPassword = null;
	
	/**
	 * 重复密码
	 * @var string
	 */
	public $rePassword = null;
	
	
	/**
	 * {@inheritDoc}
	 * @see \yii\base\Model::rules()
	 */
	public function rules() {
		return [
			['username', 'required', 'on' => ['login'], 'message' => '用户名必须填写'],
			['password', 'checkPassword', 'on' => ['login', 'chg-my-passwd'], 'skipOnEmpty' => false],
			['verifyCode', 'checkVerify', 'on' => ['login'], 'skipOnEmpty' => false],
			['oldPassword', 'checkOldPassword', 'on' => ['chg-my-passwd'], 'skipOnEmpty' => false],
			['rePassword', 'compare', 'compareAttribute' => 'password', 'on' => ['chg-my-passwd'], 'skipOnEmpty' => false, 'message' => '重复密码和新密码不相等']
		];
	}
	
	/**
	 * 检查验证码
	 */
	public function checkVerify() : void {
		if (empty($this->verifyCode)) {
			$this->addError('verifyCode', '验证码必须填写');
		} elseif (VerifyUtil::checkVerify($this->verifyCode)) {
			$this->addError('verifyCode', '验证码不正确');
		}
	}
	
	/**
	 * 管理员登录
	 * @return bool true表示登录成功,false表示登录失败
	 */
	public function login() : bool {
		$cmsAdmin = CmsAdmin::instance()->getByColumn('username', $this->username);
		if (empty($cmsAdmin)) {
			$this->addError('username', '用户名错误');
		} elseif ($cmsAdmin['password'] != StringUtil::genPassword($this->password, $cmsAdmin['salt'])) {
			$this->addError('password', '密码错误');
		}
		if ($this->hasErrors()) {
			return false;
		}
		CmsAdmin::login($cmsAdmin);
		return true;
	}
	
	/**
	 * 检查旧密码
	 */
	public function checkOldPassword() : void {
		if (empty($this->oldPassword)) {
			$this->addError('oldPassword', '就密码必须填写');
		} else {
			$currentLoginId = CmsAdmin::loginInfo('id');
			//获取当前登录用户
			$cmsAdmin = CmsAdmin::instance()->get($currentLoginId);
			if (StringUtil::genPassword($this->oldPassword, $cmsAdmin['salt']) != $cmsAdmin['password']) {
				$this->addError('oldPassword', '就密码不正确');
			}
		}
	}
	
	/**
	 * 检查密码
	 */
	public function checkPassword() : void {
		$passwordName = '密码';
		if ($this->getScenario() == 'chg-my-passwd') {
			$passwordName = '新密码';
		}
		if (empty($this->password)) {
			$this->addError('password', "{$passwordName}不能为空");
		}
		if ($this->getScenario() == 'chg-my-passwd' && $this->password == $this->oldPassword) {
			$this->addError('password', '新旧密码不能相等');
		}
	}
}