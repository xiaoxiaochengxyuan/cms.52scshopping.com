<?php
namespace app\forms;
use yii\base\Model;
/**
 * 网站基本信息Form
 * @author xiawei
 */
class WebinfoForm extends Model {
	/**
	 * 网站名称
	 * @var string
	 */
	public $web_name = null;
	
	/**
	 * 网站关键字
	 * @var string
	 */
	public $keywords = null;
	
	/**
	 * 网站描述
	 * @var string
	 */
	public $desc = null;
	
	/**
	 * 关于我们
	 * @var string
	 */
	public $about_us = null;
	
	
	public function rules() {
		return [
			['web_name', 'required', 'on' => ['edit'], 'message' => '网站名称不能为空'],
			['keywords', 'required', 'on' => ['edit'], 'message' => '网站关键字不能为空'],
			['desc', 'required', 'on' => ['edit'], 'message' => '网站描述不能为空'],
			['about_us', 'required', 'on' => ['edit'], 'message' => '关于我们不能为空']
		];
	}
}