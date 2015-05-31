<?php

if (!defined('IN_CKFINDER')) exit;




class CKFinder_Connector_Core_ThumbnailsConfig
{

    
    var  $_url = "";
    
    var $_directory = "";
    
    var $_isEnabled = false;
    
    var $_directAccess = false;
    
    var $_maxWidth = 100;
    
    var $_maxHeight = 100;
    
    var $_quality = 100;
    
    var $_bmpSupported = false;

    function CKFinder_Connector_Core_ThumbnailsConfig($thumbnailsNode)
    {
        if(extension_loaded('gd') && isset($thumbnailsNode['enabled'])) {
            $this->_isEnabled = CKFinder_Connector_Utils_Misc::booleanValue($thumbnailsNode['enabled']);
        }
        if( isset($thumbnailsNode['directAccess'])) {
            $this->_directAccess = CKFinder_Connector_Utils_Misc::booleanValue($thumbnailsNode['directAccess']);
        }
        if( isset($thumbnailsNode['bmpSupported'])) {
            $this->_bmpSupported = CKFinder_Connector_Utils_Misc::booleanValue($thumbnailsNode['bmpSupported']);
        }
        if(isset($thumbnailsNode['maxWidth'])) {
            $_maxWidth = intval($thumbnailsNode['maxWidth']);
            if($_maxWidth>=0) {
                $this->_maxWidth = $_maxWidth;
            }
        }
        if(isset($thumbnailsNode['maxHeight'])) {
            $_maxHeight = intval($thumbnailsNode['maxHeight']);
            if($_maxHeight>=0) {
                $this->_maxHeight = $_maxHeight;
            }
        }
        if(isset($thumbnailsNode['quality'])) {
            $_quality = intval($thumbnailsNode['quality']);
            if($_quality>0 && $_quality<=100) {
                $this->_quality = $_quality;
            }
        }

        if(isset($thumbnailsNode['url'])) {
            $this->_url = $thumbnailsNode['url'];
        }
        if (!strlen($this->_url)) {
            $this->_url = "/";
        }
        else if(substr($this->_url,-1,1) != "/") {
            $this->_url .= "/";
        }

        if(isset($thumbnailsNode['directory'])) {
            $this->_directory = $thumbnailsNode['directory'];
        }
    }

    
    function getUrl()
    {
        return $this->_url;
    }

    
    function getDirectory()
    {
        return $this->_directory;
    }

    
    function getIsEnabled()
    {
        return $this->_isEnabled;
    }

    
    function getBmpSupported()
    {
        return $this->_bmpSupported;
    }

    
    function getDirectAccess()
    {
        return $this->_directAccess;
    }

    
    function getMaxWidth()
    {
        return $this->_maxWidth;
    }

    
    function getMaxHeight()
    {
        return $this->_maxHeight;
    }

    
    function getQuality()
    {
        return $this->_quality;
    }
}
