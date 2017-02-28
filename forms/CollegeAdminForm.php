<?php
namespace app\forms;
use yii\base\Model;
use app\daos\CollegeAdmin;
use app\daos\College;
use app\utils\StringUtil;
/**
 * 大学对应的Form表单
 * @author xiawei
 */
class CollegeAdminForm extends Model {
	/**
	 * 主键
	 * @var integer
	 */
	public $id = 0;
	/**
	 * 用户名
	 * @var string
	 */
	public $username = null;
	
	/**
	 * 对应的电话号码
	 * @var string
	 */
	public $phone = null;
	
	/**
	 * 对应的大学id
	 * @var integer
	 */
	public $college_id = 0;
	
	/**
	 * {@inheritDoc}
	 * @see \yii\base\Model::rules()
	 */
	public function rules() {
		return [
			['usenrame', 'checkUsername', 'on' => ['add', 'update'], 'skipOnEmpty' => false],
			['college_id', 'checkCollegeId', 'on' => ['add', 'update'], 'skipOnEmpty' => false],
			['phone', 'checkPhone', 'on' => ['add', 'update'], 'skipOnEmpty' => false]
		];
	}
	
	/**
	 * 检查用户名
	 */
	public function checkUsername() {
		if (empty($this->username)) {
			$this->addError('username', '用户名必须填写');
		} elseif ($this->getScenario() == 'add' && CollegeAdmin::instance()->existsByColumn('username', $this->username)) {
			$this->addError('username', '该用户名已经被注册');
		} elseif ($this->getScenario() == 'update' && CollegeAdmin::instance()->existsColumnWithoutPrimarykey('username', $this->username, $this->id)) {
			$this->addError('username', '该用户名已经被注册');
		}
	}
	
	
	public function checkCollegeId() {
		if (empty($this->college_id)) {
			$this->addError('college_id', '大学Id必须提交');
		} elseif (!College::instance()->existsByColumn('id', $this->college_id)) {
			$this->addError('college_id', '对应的大学不存在');
		}
	}
	
	
	/**
	 * 检查手机号码
	 */
	public function checkPhone() {
		if (empty($this->phone)) {
			$this->addError('phone', '手机号码必须填写');
		} elseif (!StringUtil::isMobile($this->phone)) {
			$this->addError('phone', '手机号码格式不正确');
		}
	}
}