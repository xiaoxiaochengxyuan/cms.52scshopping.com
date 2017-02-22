<?php
namespace app\forms;
use yii\base\Model;
use app\daos\ProductCat;
/**
 * 商品分类Form表单
 * @author xiawei
 */
class ProductCatForm extends Model {
	/**
	 * 商品分类名称
	 * @var string
	 */
	public $name = null;
	
	/**
	 * 英文名称
	 * @var string
	 */
	public $en_name = null;
	
	/**
	 * 对应的父级别id
	 * @var string
	 */
	public $pid = 0;
	
	/**
	 * {@inheritDoc}
	 * @see \yii\base\Model::rules()
	 */
	public function rules() {
		return [
			['name', 'checkName', 'on' => ['add']]
		];
	}
	
	
	/**
	 * 检查名称
	 */
	public function checkName() : void {
		if (empty($this->name)) {
			$this->addError('name', '商品分类名称必须填写');
		} elseif ($this->getScenario() == 'add' && ProductCat::instance()->existsByColumnAndPid('name', $this->name, $this->pid)) {
			$this->addError('name', '商品分类名称重复');
		}
	}
	
	/**
	 * 检查对应的英文名称
	 */
	public function checkEnName() : void {
		if (empty($this->en_name)) {
			$this->addError('en_name', '商品分类英文名称必须填写');
		} elseif ($this->getScenario() == 'add' && ProductCat::instance()->existsByColumnAndPid('en_name', $this->en_name, $this->pid)) {
			$this->addError('en_name', '商品分类英文名称重复');
		}
	}
}