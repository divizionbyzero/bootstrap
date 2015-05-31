<?php

if (!defined('IN_CKFINDER')) exit;




require_once CKFINDER_CONNECTOR_LIB_DIR . "/CommandHandler/XmlCommandHandlerBase.php";


class CKFinder_Connector_CommandHandler_DeleteFile extends CKFinder_Connector_CommandHandler_XmlCommandHandlerBase
{
    
    private $command = "DeleteFile";


    
    protected function buildXml()
    {
        if (empty($_POST['CKFinderCommand']) || $_POST['CKFinderCommand'] != 'true') {
            $this->_errorHandler->throwError(CKFINDER_CONNECTOR_ERROR_INVALID_REQUEST);
        }

        if (!$this->_currentFolder->checkAcl(CKFINDER_CONNECTOR_ACL_FILE_DELETE)) {
            $this->_errorHandler->throwError(CKFINDER_CONNECTOR_ERROR_UNAUTHORIZED);
        }

        if (!isset($_GET["FileName"])) {
            $this->_errorHandler->throwError(CKFINDER_CONNECTOR_ERROR_INVALID_NAME);
        }

        $fileName = CKFinder_Connector_Utils_FileSystem::convertToFilesystemEncoding($_GET["FileName"]);
        $_resourceTypeInfo = $this->_currentFolder->getResourceTypeConfig();

        if (!CKFinder_Connector_Utils_FileSystem::checkFileName($fileName) || $_resourceTypeInfo->checkIsHiddenFile($fileName)) {
            $this->_errorHandler->throwError(CKFINDER_CONNECTOR_ERROR_INVALID_REQUEST);
        }

        if (!$_resourceTypeInfo->checkExtension($fileName, false)) {
            $this->_errorHandler->throwError(CKFINDER_CONNECTOR_ERROR_INVALID_REQUEST);
        }

        $filePath = CKFinder_Connector_Utils_FileSystem::combinePaths($this->_currentFolder->getServerPath(), $fileName);

        $bDeleted = false;

        if (!file_exists($filePath)) {
            $this->_errorHandler->throwError(CKFINDER_CONNECTOR_ERROR_FILE_NOT_FOUND);
        }

        if (!@unlink($filePath)) {
            $this->_errorHandler->throwError(CKFINDER_CONNECTOR_ERROR_ACCESS_DENIED);
        } else {
            $bDeleted = true;
        }

        if ($bDeleted) {
            $thumbPath = CKFinder_Connector_Utils_FileSystem::combinePaths($this->_currentFolder->getThumbsServerPath(), $fileName);

            @unlink($thumbPath);

            $oDeleteFileNode = new Ckfinder_Connector_Utils_XmlNode("DeletedFile");
            $this->_connectorNode->addChild($oDeleteFileNode);

            $oDeleteFileNode->addAttribute("name", $fileName);
        }
    }
}
