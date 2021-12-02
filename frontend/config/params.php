<?php

define('TAB_INDEX', 0); // 首页
define('TAB_TIPS', 1); // 首页
define('TAB_NATIONALITY', 2); // 首页
define('TAB_IDENTITYCARD', 3); // 首页
define('TAB_IDENTITY', 4); // 首页
define('TAB_CONTACTINFO', 5); // 联系信息
define('TAB_PERSONINFO', 6); // 个人信息
define('TAB_EMPLOYINFO', 7); // 雇佣信息
define('TAB_WEALTHSOURCE', 8); // 财富来源
define('TAB_INCOMEASSET', 9); // 收入和资产总值
define('TAB_UPLOADPROOF', 10); // 证明上传
define('TAB_ACCOUNTINFO', 11); // 账户信息
define('TAB_OBJECTIVE', 12); // 投资目标
define('TAB_EXPERIENCE', 13); // 投资经验
define('TAB_PERMISSION', 14); // 股票权限
define('TAB_REGULATORY', 15); // 监管信息
define('TAB_SUREINFO', 16); // 信息确认
define('TAB_AGREEMENT', 17); // 签字确认
//define('TAB_SURESIGN', 16); // 签字确认
define('TAB_END', 18); // 首页

return [
    'adminEmail' => 'admin@example.com',
    'pageTab' => [
        TAB_INDEX => 'index',
        TAB_TIPS => 'tips',
        TAB_NATIONALITY => 'nationality',
        TAB_IDENTITYCARD => 'identity-card',
        TAB_IDENTITY => 'identity-info',
        TAB_CONTACTINFO => '../info/contactinfo',
        TAB_PERSONINFO => '../info/personinfo',
        TAB_EMPLOYINFO => '../info/employinfo',
        TAB_WEALTHSOURCE => '../info/wealthsource',
        TAB_INCOMEASSET => '../info/incomeasset',
        TAB_UPLOADPROOF => '../info/uploadproof',
        TAB_ACCOUNTINFO => '../info/accountinfo',
        TAB_OBJECTIVE => '../info/objective',
        TAB_EXPERIENCE => '../info/experience',
        TAB_PERMISSION => '../info/permissions',
        TAB_REGULATORY => 'regulatory',
        TAB_SUREINFO => 'sure-info',
        TAB_AGREEMENT => 'agreements',
//        TAB_SURESIGN => 'sure-sign',
        TAB_END => '../info/success',
    ],
];
