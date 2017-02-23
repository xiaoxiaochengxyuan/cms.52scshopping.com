<?php
namespace app\utils;
use OSS\OssClient;
use yii\web\UploadedFile;

/**
 * 阿里云Oss对应的工具类
 * @author xiawei
 */
class OssUtil {
	/**
	 * 阿里云OssClient客户端
	 * @var OssClient
	 */
	private static $OSS_CLIENT = null;
	
	/**
	 * 获取阿里OssClient客户端
	 * @return \OSS\OssClient
	 */
	private static function getOssClient() : OssClient {
		if (empty(self::$OSS_CLIENT)) {
			self::$OSS_CLIENT = new OssClient(
				\Yii::$app->params['oss']['accessKeyId'],
				\Yii::$app->params['oss']['accessKeySecret'],
				\Yii::$app->params['oss']['endpoint']
			);
		}
		return self::$OSS_CLIENT;
	}
	
	/**
	 * 上传文件到Oss
	 * @param UploadedFile $uploadedFile 上传文件的封装类
	 * @return string 新的文件名
	 */
	public static function uploadFile(UploadedFile $uploadedFile) {
		$bluckName = \Yii::$app->params['oss']['bluckName'];
		$extension = $uploadedFile->extension;
		$newBaseFileName = uuid_create();
		$newFileName = $newBaseFileName.'.'.$extension;
		$result = self::getOssClient()->uploadFile($bluckName, $newFileName, $uploadedFile->tempName);
		return [
			'fileName' => $newFileName,
			'url' => $result['info']['url']
		];
	}
	
	/**
	 * 获取Oss图片路径
	 * @param unknown $fileName
	 * @return string
	 */
	public static function getOssImg($fileName) {
		return \Yii::$app->params['oss']['oss_base_url'].'/'.$fileName;
	}
}