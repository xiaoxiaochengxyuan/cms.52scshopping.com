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
	public static function isUploadImg(UploadedFile $uploadedFile) {
		$imageExtensions = ['jpg', 'gif', 'png'];
		return in_array($uploadedFile->extension, $imageExtensions);
	}
	
	
	/**
	 * 检查一个数是不是正数
	 * @param unknow $number
	 * @return bool
	 */
	public static function isPlusNumber($number) {
		if (is_numeric($number) && $number > 0) {
			return true;
		}
		return false;
	}
	
	/**
	 * 判断一个数是不是正整数
	 * @param unknow $int
	 * @return boolean
	 */
	public static function isPlusInt($int) {
		return intval($int) == $int && self::isPlusNumber($int);
	}
	
	
	/**
	 * 格式化输出数据
	 * @param unknown $var 要输出 的变量 
	 */
	public static function formatPrint($var) {
		echo '<pre>';
		print_r($var);
		die('</pre>');
	}
}