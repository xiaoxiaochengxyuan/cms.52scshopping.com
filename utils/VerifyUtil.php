<?php
namespace app\utils;
use yii\web\Cookie;

/**
 * 验证码工具类
 * @author xiawei
 */
class VerifyUtil {
    /**
     * 验证码在cookie中的key
     * @var string
     */
    const VERIFYKEY = 'verify_code_session_key';
    /**
     * 随机因子
     * @var string
     */
    const VERIFY_ZHONGZI = 'abcdefhkmnprstuvwxyABCDEFHKMNPRSTUVWXY345678';
    
    /**
     * 创建图片
     * @param integer $length
     * @param integer $imageWidhth
     * @param integer $imageHeight
     * @param integer $fontsize
     * @param integer $jianxi
     */
    public static function createImg($length = 4, $imageWidth = 130, $imageHeight = 50, $fontsize = 20) {
        $code = self::createCode($length);
        $img = self::createBg($imageWidth, $imageHeight);
        $img = self::createLine($img, $imageWidth, $imageHeight);
        $font = __DIR__.DIRECTORY_SEPARATOR.'IMPACT.TTF';
        $img = self::createFont($img, $font, $fontsize, $code, $imageWidth, $imageHeight, $length);
        $cookie = new Cookie(['name' => self::VERIFYKEY, 'value' => sha1($code)]);
        \Yii::$app->response->cookies->add($cookie);
        header('Content-type:image/png');
        imagepng($img);
        imagedestroy($img);
    }
    
    /**
     * 创建随机验证码
     * @param integer $length
     */
    private static function createCode($length) {
        $zhongzi = self::VERIFY_ZHONGZI;
        $len = strlen($zhongzi) - 1;
        $code = '';
		for($i = 0; $i < $length; $i ++) {
			$code .= $zhongzi[mt_rand(0, $len)];
		}
		$code = strtolower($code);
		return $code;
    }
    
    /**
     * 创建背景图
     * @param integer $imageWidth  图片宽度
     * @param integer $imageHeight 图片高度
     * @return resource
     */
    private static function createBg($imageWidth, $imageHeight) {
        $img = imagecreatetruecolor($imageWidth, $imageHeight);
        $color = imagecolorallocate ($img, mt_rand(157, 255), mt_rand(157, 255), mt_rand(157, 255));
        imagefilledrectangle($img, 0, $imageHeight, $imageWidth, 0, $color);
        return $img;
    }
    
    
    /**
     * 生成线条、雪花
     */
    private static function createLine($img, $imageWidth, $imageHeight) {
        for($i = 0; $i < 6; $i ++) {
            $color = imagecolorallocate($img, mt_rand(0, 156), mt_rand(0, 156), mt_rand ( 0, 156));
            imageline($img, mt_rand(0, $imageWidth), mt_rand(0, $imageHeight), mt_rand(0, $imageWidth), mt_rand (0, $imageHeight), $color);
        }
        for($i = 0; $i < 100; $i ++) {
            $color = imagecolorallocate($img, mt_rand(200, 255), mt_rand(200, 255), mt_rand(200, 255));
            imagestring($img, mt_rand(1, 5), mt_rand(0, $imageWidth), mt_rand(0, $imageHeight), '*', $color);
        }
        return $img;
    }
    
    /**
     * 生成文字
     */
    private static function createFont($img, $font, $fontSize, $code, $imageWidth, $imageHeight, $length) {
        $_x = $imageWidth / $length;
        for($i = 0; $i < $length; $i++) {
            $fontColor = imagecolorallocate($img, mt_rand(0, 156), mt_rand(0, 156), mt_rand(0, 156));
            imagettftext($img, $fontSize, mt_rand(-30, 30), $_x * $i + mt_rand(15, 20), $imageHeight / 1.2, $fontColor, $font, $code[$i]);
        }
        return $img;
    }
    
    /**
     * 检查验证码是否正确
     * @param string $verify 验证码
     * @return boolean true表示正确,false表示不正确
     */
    public static function checkVerify($verify) {
        $verify = strtolower($verify);
        $verify = sha1($verify);
        return $verify == \Yii::$app->request->cookies->getValue(self::VERIFYKEY);
    }
}