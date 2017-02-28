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
	 * {@inheritDoc}
	 * @see \yii\base\Widget::run()
	 */
	public function run() {
		return $this->render('alert-msg', ['view' => $this->view]);
	}
}