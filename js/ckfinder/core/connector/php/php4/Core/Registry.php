<?php

if (!defined('IN_CKFINDER')) exit;




class CKFinder_Connector_Core_Registry
{
    
    var $_store = array();

    
    function isValid($key)
    {
        return array_key_exists($key, $this->_store);
    }

    
    function set($key, $obj)
    {
        $this->_store[$key] = $obj;
    }

    
    function get($key)
    {
    	if ($this->isValid($key)) {
    	    return $this->_store[$key];
    	}
    }
}
