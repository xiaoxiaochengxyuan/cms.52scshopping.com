<?php
require_once __DIR__.'/defines.php';
return [
    'adminEmail' => 'admin@example.com',
    'noLogin' => [
        'login' => ['index'],
        'common' => ['verify'],
    ],
    //定义权限
    'auth' => [
        'college' => ['*' => CMS_ADMIN_SUPER_LEVEL],
        'college-admin' => ['*' => CMS_ADMIN_SUPER_LEVEL]
    ],
    'oss' => [
        'accessKeyId' => 'u8k8cQq7XkBT5Q41',
        'accessKeySecret' => '9xgSa9NsvXUwe91cR8ztcGP2paa93x',
        'endpoint' => 'http://oss-cn-shenzhen.aliyuncs.com',
        'bluckName' => 'scshopping-test',
        'oss_base_url' => 'http://scshopping-test.oss-cn-shenzhen.aliyuncs.com'
    ]
];
