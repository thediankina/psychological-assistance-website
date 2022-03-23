<?php

return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'My Web Application',
    'language' => 'ru',

    'preload' => array('log', 'debug'),

    'import' => array(
        'application.models.*',
        'application.components.*',
    ),

    'modules' => array(

        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => 'giipassword%',
            'ipFilters' => array('127.0.0.1', '::1'),
        ),

        'office' => array(
            'class' => application\modules\office\OfficeModule::class,
        ),

        'forum' => array(
            'class' => application\modules\forum\ForumModule::class,
        ),

        'admin' => array(
            'class' => application\modules\admin\AdminModule::class,
        ),
    ),

    'components' => array(

        'user' => array(
            'class' => CWebUser::class,
            'loginUrl' => '/login',
        ),

        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'appendParams' => false,
            'rules' => require(dirname(__FILE__) . '/rules.php'),
        ),

        'debug' => array('class' => 'ext.yii2-debug.Yii2Debug'),

        'db' => require(dirname(__FILE__) . '/database.php'),

        'errorHandler' => array(
            'errorAction' => YII_DEBUG ? null : 'site/error',
        ),

        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
            ),
        ),

    ),

    'params' => array(
        'adminEmail' => 'digaliulina@gmail.com',
    ),
);
