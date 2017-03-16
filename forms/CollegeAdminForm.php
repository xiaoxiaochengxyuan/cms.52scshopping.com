<?php
namespace app\forms;
use yii\base\Model;
use app\daos\CollegeAdmin;
use app\daos\College;
use app\utils\StringUtil;
use app\daos\CollegeDormArea;
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
	public $college_dorm_area_id = 0;
	
	/**
	 * 是否是超级管理员,0为不是,1为是
	 * @var integer
	 */
	public $is_super = 0;
	
	
	/**
	 * {@inheritDoc}
	 * @see \yii\base\Model::rules()
	 */
	public function rules() {
		return [
			['usenrame', 'checkUsername', 'on' => ['add', 'update'], 'skipOnEmpty' => false],
			['college_dorm_area_id', 'checkCollegeDormAreaId', 'on' => ['add', 'update'], 'skipOnEmpty' => false],
			['phone', 'checkPhone', 'on' => ['add', 'update'], 'skipOnEmpty' => false],
			['is_super', 'checkIsSuper', 'on' => ['add', 'update'], 'skipOnEmpty' => false]
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
	
	
	public function checkCollegeDormAreaId() {
		if (empty($this->college_dorm_area_id)) {
			$this->addError('college_dorm_area_id', '大学区域Id必须提交');
		} elseif (!CollegeDormArea::instance()->existsByColumn('id', $this->college_dorm_area_id)) {
			$this->addError('college_dorm_area_id', '大学区域Id不存在');
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
	
	/**
	 * 检查是否是超级管理员字段
	 */
	public function checkIsSuper() {
		if ($this->is_super == 1) {
			$condition = ['and', 'is_super=1', "college_dorm_area_id={$this->college_dorm_area_id}"];
			if ($this->getScenario() == 'add') {
				$condition[] = "id<>{$this->id}";
			}
			if (CollegeAdmin::instance()->existsByCondition($condition)) {
				$this->addError('is_super', '已经存在超级管理员,不能重复添加超级管理员');
			}
		}
	}
}