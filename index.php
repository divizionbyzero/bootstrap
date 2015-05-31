<?php
defined('YII_DEBUG') or define('YII_DEBUG',true);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($_SERVER['DOCUMENT_ROOT'].'/library/yii.php');

$config_file = $_SERVER['DOCUMENT_ROOT'].'/application/config/main.php';
Yii::createWebApplication($config_file)->run();