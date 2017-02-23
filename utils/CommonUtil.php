<?php
namespace app\utils;
use yii\web\UploadedFile;

/**
 * 一些公共的方法的封装
 * @author xiawei
 */
class CommonUtil {
	/**
	 * 判断上传文件是否是图片
	 * @param UploadedFile $uploadedFile
	 * @return bool
	 */
	public static function isUploadImg(UploadedFile $uploadedFile) : bool {
		$imageExtensions = ['jpg', 'gif', 'png'];
		return in_array($uploadedFile->extension, $imageExtensions);
	}
}