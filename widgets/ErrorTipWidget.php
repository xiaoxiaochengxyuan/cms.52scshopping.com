<?php
namespace app\widgets;
use yii\base\Widget;
use yii\base\Model;
/**
 * 错误信息对应的Widget
 * @author xiawei
 */
class ErrorTipWidget extends Widget {
	/**
	 * 对应的Form表单
	 * @var Model
	 */
	public $form = null;
	
	/**
	 * 对应的字段名称
	 * @var string
	 */
	public $attribute = null;
	
	
	/**
	 * {@inheritDoc}
	 * @see \yii\base\Widget::run()
	 */
	public function run() {
		return $this->render('error-tip', ['form' => $this->form, 'attribute' => $this->attribute]);
	}
}