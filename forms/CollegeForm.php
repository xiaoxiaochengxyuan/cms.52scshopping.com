<?php
namespace app\forms;
use yii\base\Model;
use app\daos\College;
/**
 * 大学对应的Form表单
 * @author xiawei
 */
class CollegeForm extends Model {
	/**
	 * 大学对应的id
	 * @var integer
	 */
	public $id = 0;
	/**
	 * 大学名称
	 * @var string
	 */
	public $name = null;
	
	/**
	 * 对应的区域Id
	 * @var integer
	 */
	public $region_id = 0;
	
	/**
	 * 对应的城市Id
	 * @var integer
	 */
	public $city_id = 0;
	
	/**
	 * 对应的省份id
	 * @var integer
	 */
	public $province_id = 0;
	
	/**
	 * 对应的详细地址
	 * @var string
	 */
	public $detail_address = '';
	
	/**
	 * {@inheritDoc}
	 * @see \yii\base\Model::rules()
	 */
	public function rules() {
		return [
			['name', 'checkName', 'on' => ['add', 'update'], 'skipOnEmpty' => false],
			['detail_address', 'required', 'on' => ['add'], 'message' => '详细地址必须填写']
		];
	}
	
	/**
	 * 检查名字
	 */
	public function checkName() {
		if (empty($this->name)) {
			$this->addError('name', '名字不能为空');
		} elseif ($this->getScenario() == 'add' && College::instance()->existsByColumn('name', $this->name)) {
			$this->addError('name', '该大学已经被添加过');
		} elseif ($this->getScenario() == 'update' && College::instance()->existsNameWithoutId($this->name, $this->id)) {
			$this->addError('name', '该大学已存在');
		}
	}
}