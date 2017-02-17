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
}