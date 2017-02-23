<?php
namespace app\controllers;
use app\base\BaseWebController;
use app\utils\VerifyUtil;
use app\daos\Region;
use yii\web\UploadedFile;
use app\utils\OssUtil;
use yii\web\Response;
use app\utils\CommonUtil;
use yii\base\Exception;
/**
 * 提供一些公共方法的Controller
 * @author xiawei
 */
class CommonController extends BaseWebController {
	private $noCsrf = ['upload-img', 'editor-upload-img'];
	/**
	 * {@inheritDoc}
	 * @see \yii\web\Controller::beforeAction()
	 */
	public function beforeAction($action) {
		if (in_array($action->id, $this->noCsrf)) {
			$this->enableCsrfValidation = false;
		}
		return parent::beforeAction($action);
	}
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
	
	/**
	 * 获取对应的Region
	 */
	public function actionGetRegions() {
		$pid = \Yii::$app->request->get('pid');
		$regions = Region::instance()->droplistData($pid);
		return $this->renderPartial('get-regions', ['regions' => $regions]);
	}
	
	/**
	 * 上传照片
	 */
	public function actionUploadImg() {
		if (empty($_FILES)) {
			throw new Exception('没有上传图片');
		}
		foreach ($_FILES as $key => $file) {
			$uploadedFile = UploadedFile::getInstanceByName($key);
			break;
		}
		if (!CommonUtil::isUploadImg($uploadedFile)) {
			throw new \RuntimeException('你上传的文件不是图片');
		}
		\Yii::$app->response->format = Response::FORMAT_JSON;
		return OssUtil::uploadFile($uploadedFile);
	}
	
	/**
	 * kindeditor上传图片
	 */
	public function actionEditorUploadImg() {
		if (empty($_FILES)) {
			throw new Exception('没有上传图片');
		}
		foreach ($_FILES as $key => $file) {
			$uploadedFile = UploadedFile::getInstanceByName($key);
			break;
		}
		if (!CommonUtil::isUploadImg($uploadedFile)) {
			throw new \RuntimeException('你上传的文件不是图片');
		}
		$uploadResult = OssUtil::uploadFile($uploadedFile);
		\Yii::$app->response->format = Response::FORMAT_JSON;
		return ['error' => 0, 'url' => $uploadResult['url']];
	}
}