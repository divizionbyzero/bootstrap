<?php

if (!defined('IN_CKFINDER')) exit;




class CKFinder_Connector_ErrorHandler_Base
{
    
    var $_catchAllErrors = false;
    
    var $_skipErrorsArray = array();

    
    function setCatchAllErros($newValue)
    {
        $this->_catchAllErrors = $newValue ? true : false;
    }

    
    function setSkipErrorsArray($newArray)
    {
        if (is_array($newArray)) {
            $this->_skipErrorsArray = $newArray;
        }
    }

    
    function throwError($number, $text = false)
    {
        if ($this->_catchAllErrors || in_array($number, $this->_skipErrorsArray)) {
            return false;
        }

        $_xml =& CKFinder_Connector_Core_Factory::getInstance("Core_Xml");
        $_xml->raiseError($number,$text);

        exit;
    }
}
