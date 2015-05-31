<?php

if (!defined('IN_CKFINDER')) exit;




class CKFinder_Connector_Core_Connector
{
    
    var $_registry;

    function CKFinder_Connector_Core_Connector()
    {
        $this->_registry =& CKFinder_Connector_Core_Factory::getInstance("Core_Registry");
        $this->_registry->set("errorHandler", "ErrorHandler_Base");
    }

    
    function handleInvalidCommand()
    {
        $oErrorHandler =& $this->getErrorHandler();
        $oErrorHandler->throwError(CKFINDER_CONNECTOR_ERROR_INVALID_COMMAND);
    }

    
    function executeCommand($command)
    {
        if (!CKFinder_Connector_Core_Hooks::run('BeforeExecuteCommand', array(&$command))) {
            return;
        }

        switch ($command)
        {
            case 'FileUpload':
            $this->_registry->set("errorHandler", "ErrorHandler_FileUpload");
            $obj =& CKFinder_Connector_Core_Factory::getInstance("CommandHandler_".$command);
            $obj->sendResponse();
            break;

            case 'QuickUpload':
            $this->_registry->set("errorHandler", "ErrorHandler_QuickUpload");
            $obj =& CKFinder_Connector_Core_Factory::getInstance("CommandHandler_".$command);
            $obj->sendResponse();
            break;

            case 'DownloadFile':
            case 'Thumbnail':
            $this->_registry->set("errorHandler", "ErrorHandler_Http");
            $obj =& CKFinder_Connector_Core_Factory::getInstance("CommandHandler_".$command);
            $obj->sendResponse();
            break;

            case 'CopyFiles':
            case 'CreateFolder':
            case 'DeleteFile':
            case 'DeleteFolder':
            case 'GetFiles':
            case 'GetFolders':
            case 'Init':
            case 'MoveFiles':
            case 'RenameFile':
            case 'RenameFolder':
            $obj =& CKFinder_Connector_Core_Factory::getInstance("CommandHandler_".$command);
            $obj->sendResponse();
            break;

            default:
            $this->handleInvalidCommand();
            break;
        }
    }

    
    function &getErrorHandler()
    {
        $_errorHandler = $this->_registry->get("errorHandler");
        $oErrorHandler =& CKFinder_Connector_Core_Factory::getInstance($_errorHandler);
        return $oErrorHandler;
    }
}
