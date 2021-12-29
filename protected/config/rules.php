<?php

return array(
    'login' => 'office/auth/login',
    'logout' => 'office/auth/logout',
    'office' => 'office/office/index',
    'requests' => 'office/request/index',
    'request/accept' => 'office/request/accept',
    'request/reject' => 'office/request/reject',
    'request/finish' => 'office/request/finish',

    'request/view/<id:\d+>'=>'office/request/view/<id:\d+>',
    'article/view/<id:\d+>'=>'article/view/<id:\d+>',
);
