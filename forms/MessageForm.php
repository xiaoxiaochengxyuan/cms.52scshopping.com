<?php
namespace app\forms;
use yii\base\Model;
/**
 * 消息对应的Form
 * @author xiawei
 */
class MessageForm extends Model {
	/**
	 * 自增Id
	 * @var integer
	 */
	public $id = 0;
	
	/**
	 * 消息标题
	 * @var string
	 */
	public $title = null;
	
	/**
	 * 消息关键字
	 * @var string
	 */
	public $keywords = null;
	
	/**
	 * 描述
	 * @var string
	 */
	public $desc = null;
	
	/**
	 * 消息内容
	 * @var unknown
	 */
	public $content = null;
	
	
	
	public function rules() {
		return [
			['title', 'required', 'on' => ['add', 'update'], 'message' => '标题必须填写'],
			['keywords', 'required', 'on' => ['add', 'update'], 'message' => '消息关键字必须填写'],
			['desc', 'required', 'on' => ['add', 'update'], 'message' => '消息描述必须填写'],
			['content', 'required', 'on' => ['add', 'update'], 'message' => '消息内容必须填写']
		];
	}
}