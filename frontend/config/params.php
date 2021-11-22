<?php

define('TAB_INDEX', 0); // 首页
define('TAB_TIPS', 1); // 首页
define('TAB_NATIONALITY', 2); // 首页
define('TAB_IDENTITYCARD', 3); // 首页
define('TAB_IDENTITY', 4); // 首页
define('TAB_ADDRESS', 5); // 首页
define('TAB_OCCUPATION', 6); // 首页
define('TAB_ACCOUNTTYPE', 7); // 首页
define('TAB_ASSETS', 8); // 首页
define('TAB_AUTOGRAPH', 9); // 首页
define('TAB_COMMISSION', 10); // 首页
define('TAB_REGULATORY', 11); // 监管信息
define('TAB_SUREINFO', 12); // 信息确认
define('TAB_SURESIGN', 13); // 签字确认
define('TAB_END', 14); // 首页

return [
    'adminEmail' => 'admin@example.com',
    'pageTab' => [
        TAB_INDEX => 'index',
        TAB_TIPS => 'tips',
        TAB_NATIONALITY => 'nationality',
        TAB_IDENTITYCARD => 'identity-card',
        TAB_IDENTITY => 'identity-info',
        TAB_ADDRESS => 'address',
        TAB_OCCUPATION => 'occupation',
        TAB_ACCOUNTTYPE => 'account-type',
        TAB_ASSETS => 'assets',
        TAB_AUTOGRAPH => 'autograph',
        TAB_COMMISSION => 'commission',
        TAB_REGULATORY => 'regulatory',
        TAB_SUREINFO => 'sure-info',
        TAB_SURESIGN => 'sure-sign',
        TAB_END => 'end',
    ],
];
