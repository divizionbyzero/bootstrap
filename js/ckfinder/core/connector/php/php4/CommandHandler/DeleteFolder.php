<?php

if (!defined('IN_CKFINDER')) exit;




require_once CKFINDER_CONNECTOR_LIB_DIR . "/CommandHandler/XmlCommandHandlerBase.php";


class CKFinder_Connector_CommandHandler_DeleteFolder extends CKFinder_Connector_CommandHandler_XmlCommandHandlerBase
{
    
    var $command = "DeleteFolder";


    
    function buildXml()
    {
        if (empty($_POST['CKFinderCommand']) || $_POST['CKFinderCommand'] != 'true') {
            $this->_errorHandler->throwError(CKFINDER_CONNECTOR_ERROR_INVALID_REQUEST);
        }

        if (!$this->_currentFolder->checkAcl(CKFINDER_CONNECTOR_ACL_FOLDER_DELETE)) {
            $this->_errorHandler->throwError(CKFINDER_CONNECTOR_ERROR_UNAUTHORIZED);
        }

                if ($this->_currentFolder->getClientPath() == "/") {
            $this->_errorHandler->throwError(CKFINDER_CONNECTOR_ERROR_INVALID_REQUEST);
        }

        $folderServerPath = $this->_currentFolder->getServerPath();
        if (!file_exists($folderServerPath) || !is_dir($folderServerPath)) {
            $this->_errorHandler->throwError(CKFINDER_CONNECTOR_ERROR_FOLDER_NOT_FOUND);
        }

        if (!CKFinder_Connector_Utils_FileSystem::unlink($folderServerPath)) {
            $this->_errorHandler->throwError(CKFINDER_CONNECTOR_ERROR_ACCESS_DENIED);
        }

        CKFinder_Connector_Utils_FileSystem::unlink($this->_currentFolder->getThumbsServerPath());
    }
}
