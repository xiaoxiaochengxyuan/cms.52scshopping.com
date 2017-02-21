<?php
namespace app\forms;
use yii\base\Model;
/**
 * 大学对应的Form表单
 * @author xiawei
 */
class CollegeForm extends Model {
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
		return [];
	}
}