<?php
namespace app\controllers;
use app\base\BaseWebController;
use app\utils\VerifyUtil;
/**
 * 提供一些公共方法的Controller
 * @author xiawei
 */
class CommonController extends BaseWebController {
	/**
	 * 验证码Action
	 */
	public function actionVerify() {
		$length = \Yii::$app->request->get('len', 4);
		$imageWidth = \Yii::$app->request->get('iw', 130);
		$imageHeight = \Yii::$app->request->get('ih', 50);
		$fontsize = \Yii::$app->request->get('fs', 20);
		VerifyUtil::createImg($length, $imageWidth, $imageHeight, $fontsize);
	}
}