<?php
namespace app\widgets;
use yii\base\Widget;
use yii\web\View;
/**
 * 打印信息小物件
 * @author xiawei
 */
class AlertMsgWidget extends Widget {
	/**
	 * 对应的视图
	 * @var View
	 */
	public $view = null;
	
	/**
	 * 视图类型
	 * @var string
	 */
	public $type = 'alert-msg';
	
	/**
	 * 错误信息
	 * @var string
	 */
	public $error = null;
	/**
	 * {@inheritDoc}
	 * @see \yii\base\Widget::run()
	 */
	public function run() {
		switch ($this->type) {
			case 'alert-msg':
				return $this->render('alert-msg/alert-msg', ['view' => $this->view]);
				break;
			case 'error':
				return $this->render('alert-msg/alert-error', ['error' => $this->error]);
		}
	}
}