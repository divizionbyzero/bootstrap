<?php

if (!defined('IN_CKFINDER')) exit;




require_once CKFINDER_CONNECTOR_LIB_DIR . "/ErrorHandler/Base.php";


class CKFinder_Connector_ErrorHandler_Http extends CKFinder_Connector_ErrorHandler_Base
{
    
    function throwError($number, $text = false, $exit = true)
    {
        if ($this->_catchAllErrors || in_array($number, $this->_skipErrorsArray)) {
            return false;
        }

        switch ($number)
        {
            case CKFINDER_CONNECTOR_ERROR_INVALID_REQUEST:
            case CKFINDER_CONNECTOR_ERROR_INVALID_NAME:
            case CKFINDER_CONNECTOR_ERROR_THUMBNAILS_DISABLED:
            case CKFINDER_CONNECTOR_ERROR_UNAUTHORIZED:
                header("HTTP/1.0 403 Forbidden");
                header("X-CKFinder-Error: ". $number);
                break;

            case CKFINDER_CONNECTOR_ERROR_ACCESS_DENIED:
                header("HTTP/1.0 500 Internal Server Error");
                header("X-CKFinder-Error: ".$number);
                break;

            default:
                header("HTTP/1.0 404 Not Found");
                header("X-CKFinder-Error: ". $number);
                break;
        }

        if ($exit) {
            exit;
        }
    }
}
