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
	
	
	/**
	 * 检查一个数是不是正数
	 * @param $number
	 * @return bool
	 */
	public static function isPlusNumber($number) : bool {
		if (is_numeric($number) && $number >= 0) {
			return true;
		}
		return false;
	}
}