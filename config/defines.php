<?php
//定义cms后台超级管理员等级
defined('CMS_ADMIN_SUPER_LEVEL') or define('CMS_ADMIN_SUPER_LEVEL', 1);
//定义cms后台大学管理员等级
defined('CMS_ADMIN_COLLEGE_LEVEL') or define('CMS_ADMIN_COLLEGE_LEVEL', 2);


/**
 * 下面是定义错误代码
 */
//不能删除错误代码
defined('ERROR_CODE_CANNOT_DELETE') or define('ERROR_CODE_CANNOT_DELETE', 506);
//成功代码
defined('ERROR_CODE_NONE') or define('ERROR_CODE_NONE', 200);
//失败操作代码
defined('ERROR_CODE_OPTION_FAILED') or define('ERROR_CODE_OPTION_FAILED', 507);