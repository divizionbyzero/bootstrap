<?php

if (!defined('IN_CKFINDER')) exit;




require_once CKFINDER_CONNECTOR_LIB_DIR . "/ErrorHandler/Base.php";


class CKFinder_Connector_ErrorHandler_FileUpload extends CKFinder_Connector_ErrorHandler_Base
{
    
    function throwError($number, $uploaded = false, $exit = true) {
        if ($this->_catchAllErrors || in_array($number, $this->_skipErrorsArray)) {
            return false;
        }

        $oRegistry = & CKFinder_Connector_Core_Factory :: getInstance("Core_Registry");
        $sFileName = $oRegistry->get("FileUpload_fileName");
        $sFileUrl = $oRegistry->get("FileUpload_url");

        header('Content-Type: text/html; charset=utf-8');

        $errorMessage = CKFinder_Connector_Utils_Misc :: getErrorMessage($number, $sFileName);
        if (!$uploaded) {
            $sFileName = "";
        }

        echo "<script type=\"text/javascript\">";

        if (!empty($_GET['CKFinderFuncNum'])) {
            $errorMessage = CKFinder_Connector_Utils_Misc::getErrorMessage($number, $sFileName);

            if (!$uploaded) {
                $sFileUrl = "";
                $sFileName = "";
            }

            $funcNum = preg_replace("/[^0-9]/", "", $_GET['CKFinderFuncNum']);
            echo "window.parent.CKFinder.tools.callFunction($funcNum, '" . str_replace("'", "\\'", $sFileUrl . $sFileName) . "', '" .str_replace("'", "\\'", $errorMessage). "');";
        }
        else {
            echo "window.parent.OnUploadCompleted('" . str_replace("'", "\\'", $sFileName) . "', '" . str_replace("'", "\\'", $errorMessage) . "') ;";
        }

        echo "</script>";

        if ($exit) {
            exit;
        }
    }
}
