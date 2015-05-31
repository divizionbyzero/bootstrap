<?php

if (!defined('IN_CKFINDER')) exit;




class CKFinder_Connector_Core_Factory
{
    
    function initFactory()
    {
        $GLOBALS['CKFinder_Connector_Factory']=array();
    }

    
    function &getInstance($className)
    {
        $namespace = "CKFinder_Connector_";

        $baseName = str_replace($namespace,"",$className);

        $className = $namespace.$baseName;

        if (!isset($GLOBALS['CKFinder_Connector_Factory'][$className])) {
            require_once CKFINDER_CONNECTOR_LIB_DIR . "/" . str_replace("_","/",$baseName).".php";
            $GLOBALS['CKFinder_Connector_Factory'][$className] =& new $className;
        }

        return $GLOBALS['CKFinder_Connector_Factory'][$className];
    }
}
