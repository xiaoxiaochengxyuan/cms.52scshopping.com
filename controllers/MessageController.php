<?php
namespace app\controllers;
use app\forms\MessageForm;
use app\daos\Message;
use yii\data\Pagination;
use app\base\Controller;
/**
 * 消息Controller
 * @author xiawei
 */
class MessageController extends Controller {
	/**
	 * 消息列表页
	 */
	public function actionIndex() {
		$search = \Yii::$app->getRequest()->get('search', []);
		$pagination = new Pagination();
		$pagination->totalCount = Message::instance()->countBySearch($search);
		$pagination->pageSize = 20;
		$messages = Message::instance()->pageBySearch($pagination, $search);
		$this->view->title = '消息列表页';
		return $this->render('index', ['messages' => $messages, 'pagination' => $pagination]);
	}
	
	/**
	 * 添加消息
	 */
	public function actionAdd() {
		$messageForm = new MessageForm();
		$messageForm->setScenario('add');
		if (\Yii::$app->getRequest()->getIsPost()) {
			$post = \Yii::$app->getRequest()->post('MessageForm');
			$messageForm->setAttributes($post, false);
			if ($messageForm->validate() && Message::instance()->insert($post)) {
				$this->redirect(['/message']);
			}
		}
		$this->view->title = '添加消息';
		return $this->render('add', ['messageForm' => $messageForm]);
	}
	
	/**
	 * 修改消息
	 */
	public function actionUpdate() {
		$messageForm = new MessageForm();
		$messageForm->setScenario('update');
		if (\Yii::$app->getRequest()->getIsPost()) {
			$post = \Yii::$app->getRequest()->post('MessageForm');
			$messageForm->setAttributes($post, false);
			if ($messageForm->validate() && Message::instance()->update($post['id'], $post)) {
				$this->addSuccMsg('修改消息成功');
			}
		} else {
			$id = \Yii::$app->getRequest()->get('id');
			$message = Message::instance()->get($id);
			$messageForm->setAttributes($message, false);
		}
		$this->view->title = '修改消息';
		return $this->render('update', ['messageForm' => $messageForm]);
	}
	
	/**
	 * 修改是否可用
	 */
	public function actionChgEnable() {
		$id = \Yii::$app->getRequest()->get('id');
		//获取是否可用
		$enable = Message::instance()->scalarByPrimaryKey($id, 'enable');
		if (Message::instance()->update($id, ['enable' => ($enable == 1 ? 0 : 1)])) {
			return $this->ajaxSuccReturn();
		}
		return $this->ajaxErrReturn(ERROR_CODE_OPTION_FAILED, '修改是否可用失败');
	}
}