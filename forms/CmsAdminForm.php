<?php
namespace app\forms;
use yii\base\Model;
use app\utils\VerifyUtil;
use app\daos\CmsAdmin;
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
	 * {@inheritDoc}
	 * @see \yii\base\Model::rules()
	 */
	public function rules() {
		return [
			['username', 'required', 'on' => ['login'], 'message' => '用户名必须填写'],
			['password', 'required', 'on' => ['login'], 'message' => '密码必须填写'],
			['verifyCode', 'checkVerify', 'on' => ['login'], 'skipOnEmpty' => false]
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
	 */
	public function login() : void {
		$cmsAdmin = CmsAdmin::instance();
	}
}