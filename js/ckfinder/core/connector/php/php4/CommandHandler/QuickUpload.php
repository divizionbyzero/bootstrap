<?php

if (!defined('IN_CKFINDER')) exit;




require_once CKFINDER_CONNECTOR_LIB_DIR . "/CommandHandler/FileUpload.php";


class CKFinder_Connector_CommandHandler_QuickUpload extends CKFinder_Connector_CommandHandler_FileUpload
{
    
    var $command = "QuickUpload";

    function sendResponse()
    {
        $oRegistry =& CKFinder_Connector_Core_Factory::getInstance("Core_Registry");
        $oRegistry->set("FileUpload_url", $this->_currentFolder->getUrl());

        return parent::sendResponse();
    }
}
