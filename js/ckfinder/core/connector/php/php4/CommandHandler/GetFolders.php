<?php

if (!defined('IN_CKFINDER')) exit;




require_once CKFINDER_CONNECTOR_LIB_DIR . "/CommandHandler/XmlCommandHandlerBase.php";


class CKFinder_Connector_CommandHandler_GetFolders extends CKFinder_Connector_CommandHandler_XmlCommandHandlerBase
{
    
    var $command = "GetFolders";

    
    function buildXml()
    {
        $_config =& CKFinder_Connector_Core_Factory::getInstance("Core_Config");
        if (!$this->_currentFolder->checkAcl(CKFINDER_CONNECTOR_ACL_FOLDER_VIEW)) {
            $this->_errorHandler->throwError(CKFINDER_CONNECTOR_ERROR_UNAUTHORIZED);
        }

                $_sServerDir = $this->_currentFolder->getServerPath();

        if (!is_dir($_sServerDir)) {
            $this->_errorHandler->throwError(CKFINDER_CONNECTOR_ERROR_FOLDER_NOT_FOUND);
        }

                $oFoldersNode = new Ckfinder_Connector_Utils_XmlNode("Folders");
        $this->_connectorNode->addChild($oFoldersNode);

        $files = array();
        if ($dh = @opendir($_sServerDir)) {
            while (($file = readdir($dh)) !== false) {
                if ($file != "." && $file != ".." && is_dir($_sServerDir . $file)) {
                    $files[] = $file;
                }
            }
            closedir($dh);
        } else {
            $this->_errorHandler->throwError(CKFINDER_CONNECTOR_ERROR_ACCESS_DENIED);
        }

        $resourceTypeInfo = $this->_currentFolder->getResourceTypeConfig();

        if (sizeof($files)>0) {
            natcasesort($files);
            $i=0;
            foreach ($files as $file) {
                $oAcl = $_config->getAccessControlConfig();
                $aclMask = $oAcl->getComputedMask($this->_currentFolder->getResourceTypeName(), $this->_currentFolder->getClientPath() . $file . "/");

                if (($aclMask & CKFINDER_CONNECTOR_ACL_FOLDER_VIEW) != CKFINDER_CONNECTOR_ACL_FOLDER_VIEW) {
                    continue;
                }
                if ($resourceTypeInfo->checkIsHiddenFolder($file)) {
                    continue;
                }

                                $oFolderNode[$i] = new Ckfinder_Connector_Utils_XmlNode("Folder");
                $oFoldersNode->addChild($oFolderNode[$i]);
                $oFolderNode[$i]->addAttribute("name", CKFinder_Connector_Utils_FileSystem::convertToConnectorEncoding($file));
                $oFolderNode[$i]->addAttribute("hasChildren", CKFinder_Connector_Utils_FileSystem::hasChildren($_sServerDir . $file) ? "true" : "false");
                $oFolderNode[$i]->addAttribute("acl", $aclMask);

                $i++;
            }
        }
    }
}
