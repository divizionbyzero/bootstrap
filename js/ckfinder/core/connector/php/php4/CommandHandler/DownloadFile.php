<?php

if (!defined('IN_CKFINDER')) exit;




class CKFinder_Connector_CommandHandler_DownloadFile extends CKFinder_Connector_CommandHandler_CommandHandlerBase
{
    
    var $command = "DownloadFile";

    
    function sendResponse()
    {
        if (!function_exists('ob_list_handlers') || ob_list_handlers()) {
            @ob_end_clean();
        }
        header("Content-Encoding: none");

        $this->checkConnector();
        $this->checkRequest();

        if (!$this->_currentFolder->checkAcl(CKFINDER_CONNECTOR_ACL_FILE_VIEW)) {
            $this->_errorHandler->throwError(CKFINDER_CONNECTOR_ERROR_UNAUTHORIZED);
        }

        $fileName = CKFinder_Connector_Utils_FileSystem::convertToFilesystemEncoding($_GET["FileName"]);
        $_resourceTypeInfo = $this->_currentFolder->getResourceTypeConfig();

        if (!CKFinder_Connector_Utils_FileSystem::checkFileName($fileName)) {
            $this->_errorHandler->throwError(CKFINDER_CONNECTOR_ERROR_INVALID_REQUEST);
        }

        if (!$_resourceTypeInfo->checkExtension($fileName, false)) {
            $this->_errorHandler->throwError(CKFINDER_CONNECTOR_ERROR_INVALID_REQUEST);
        }

        $filePath = CKFinder_Connector_Utils_FileSystem::combinePaths($this->_currentFolder->getServerPath(), $fileName);
        if ($_resourceTypeInfo->checkIsHiddenFile($fileName) || !file_exists($filePath) || !is_file($filePath)) {
            $this->_errorHandler->throwError(CKFINDER_CONNECTOR_ERROR_FILE_NOT_FOUND);
        }

        $fileName = CKFinder_Connector_Utils_FileSystem::convertToConnectorEncoding($fileName);

        header("Cache-Control: cache, must-revalidate");
        header("Pragma: public");
        header("Expires: 0");
        if (!empty($_GET['format']) && $_GET['format'] == 'text') {
            header("Content-Type: text/plain; charset=utf-8");
        }
        else {
            header("Content-type: application/octet-stream; name=\"" . $fileName . "\"");
            header("Content-Disposition: attachment; filename=\"" . str_replace("\"", "\\\"", $fileName). "\"");
        }
        header("Content-Length: " . filesize($filePath));
        CKFinder_Connector_Utils_FileSystem::readfileChunked($filePath);
        exit;
    }
}
