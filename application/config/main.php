<?php

return array(
    'name' => 'Athletic',
    'language'=>'ru',
    'sourceLanguage'=>'en',
    'defaultController' => 'home',
    'basePath' => 'application',
    'import' => array(
        'application.models.db.*',
        'application.models.form.*',
        'application.components.*',
        'ext.iwi.Iwi'
    ),
    'components' => array(
        'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=eplacing_athletic',
            'emulatePrepare' => true,
            'username' => 'eplacing_athlet',
            'password' => 'frog3zip',
            'charset' => 'utf8',
        ),
        'FrontController'=>array(
            'class'=>'application.components.FrontController',
        ),
        'BackendController'=>array(
            'class'=>'application.components.BackendController',
        ),
        'AppHelper'=>array(
            'class'=>'application.components.AppHelper',
        ),
        'format'=>array(
            'class'=>'system.utils.CLocalizedFormatter',
            'locale'=>'ru_RU',
        ),
        'user'=>array(
            'class' => 'WebUser',
            'allowAutoLogin'=>true,
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
        ),
        'iwi' => array(
            'class' => 'application.extensions.iwi.IwiComponent',
            // GD or ImageMagick
            'driver' => 'GD',
            // ImageMagick setup path
            //'params'=>array('directory'=>'C:/ImageMagick'),
        ),
        'clientScript'=>array(
            'scriptMap'=>array(
                'jquery.js'=>false,
            ),
        ),
        'authManager' => array(
            'class' => 'PhpAuthManager',
            'defaultRoles' => array('guest'),
        )
    ),
    'modules'=>array(
        'adm',
        'gii'=>array(
            'class'=>'system.gii.GiiModule',
            'password'=>'1921005',
        )
    )
);