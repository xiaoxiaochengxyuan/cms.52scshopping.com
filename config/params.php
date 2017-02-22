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
    ]
];
