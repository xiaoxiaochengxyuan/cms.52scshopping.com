<?php
namespace app\widgets;
use yii\base\Widget;
/**
 * 左侧导航栏对应的Widget
 * @author xiawei
 */
class NavWidget extends Widget {
	/**
	 * 对应的控制器Id
	 * @var string
	 */
	public $controllerId = null;
	
	/**
	 * 对应的Action的Id
	 * @var string
	 */
	public $actionId = null;
	
	/**
	 * {@inheritDoc}
	 * @see \yii\base\Widget::run()
	 */
	public function run() {
		return $this->render('nav', ['controllerId' => $this->controllerId, 'actionId' => $this->actionId]);
	}
}