<?php

if (!defined('IN_CKFINDER')) exit;




require_once CKFINDER_CONNECTOR_LIB_DIR . "/ErrorHandler/Base.php";


class CKFinder_Connector_ErrorHandler_QuickUpload extends CKFinder_Connector_ErrorHandler_Base
{
    
    function throwError($number, $uploaded = false, $exit = true) {
        if ($this->_catchAllErrors || in_array($number, $this->_skipErrorsArray)) {
            return false;
        }

        $oRegistry = & CKFinder_Connector_Core_Factory :: getInstance("Core_Registry");
        $sFileName = $oRegistry->get("FileUpload_fileName");
        $sFileUrl = $oRegistry->get("FileUpload_url");

        header('Content-Type: text/html; charset=utf-8');

		
        echo "<script type=\"text/javascript\">";
        if (!empty($_GET['CKEditor'])) {
            $errorMessage = CKFinder_Connector_Utils_Misc::getErrorMessage($number, $sFileName);

            if (!$uploaded) {
                $sFileUrl = "";
                $sFileName = "";
            }

            $funcNum = preg_replace("/[^0-9]/", "", $_GET['CKEditorFuncNum']);
            echo "window.parent.CKEDITOR.tools.callFunction($funcNum, '" . str_replace("'", "\\'", $sFileUrl . $sFileName) . "', '" .str_replace("'", "\\'", $errorMessage). "');";
        }
        else {
            if (!$uploaded) {
                echo "window.parent.OnUploadCompleted(" . $number . ", '', '', '') ;";
            } else {
                echo "window.parent.OnUploadCompleted(" . $number . ", '" . str_replace("'", "\\'", $sFileUrl . $sFileName) . "', '" . str_replace("'", "\\'", $sFileName) . "', '') ;";
            }
        }
        echo "</script>";

        if ($exit) {
            exit;
        }
    }
}
