<?php
namespace app\forms;
use yii\base\Model;
/**
 * 大学区域表单
 * @author xiawei
 */
class CollegeDormAreaForm extends Model {
	/**
	 * 对应的大学Id
	 * @var integer
	 */
	public $college_id = 0;
	
	/**
	 * 对应的宿舍名称
	 * @var string
	 */
	public $name = null;
	
	/**
	 * {@inheritDoc}
	 * @see \yii\base\Model::rules()
	 */
	public function rules() {
		return [
			['name', 'required', 'on' => ['add'], 'message' => '大学宿舍区域名称必须填写']
		];
	}
}