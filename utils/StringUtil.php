<?php
namespace app\utils;
/**
 * 字符串相关的工具类
 * @author xiawei
 */
class StringUtil {
	/**
	 * 加密密码
	 * @param string $password 要加密的密码
	 * @param string $salt 加密盐
	 * @return string
	 */
	public static function genPassword(string $password, string $salt) : string {
		return sha1(md5($password).sha1($salt));
	}
	
	/**
	 * 加密一个字符串
	 * @param string $str 要加密的字符串
	 * @param string $key 加密使用的key
	 * @return string 加密之后的字符串
	 */
	public static function encryStr($str, $key='5BAB6FAC-4283-4ebe-AE97-3CBCA9CA70B0') {
		return base64_encode(@mcrypt_encrypt(MCRYPT_BLOWFISH, $key, $str, MCRYPT_MODE_ECB));
	}
	
	/**
	 * 解密一个字符串
	 * @param string $str 要解密的字符串
	 * @param string $key 用来解密的key
	 * @return string 解密之后的字符串
	 */
	public static function decryStr($str, $key='5BAB6FAC-4283-4ebe-AE97-3CBCA9CA70B0') {
		return trim(@mcrypt_decrypt(MCRYPT_BLOWFISH, $key, base64_decode($str), MCRYPT_MODE_ECB));
	}
}