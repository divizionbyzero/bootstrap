<?php

if (!defined('IN_CKFINDER')) exit;




class CKFinder_Connector_Core_ImagesConfig
{
    
    var $_maxWidth = 0;
    
    var $_maxHeight = 0;
    
    var $_quality = 80;

    function CKFinder_Connector_Core_ImagesConfig($imagesNode)
    {
        if(isset($imagesNode['maxWidth'])) {
            $_maxWidth = intval($imagesNode['maxWidth']);
            if($_maxWidth>=0) {
                $this->_maxWidth = $_maxWidth;
            }
        }
        if(isset($imagesNode['maxHeight'])) {
            $_maxHeight = intval($imagesNode['maxHeight']);
            if($_maxHeight>=0) {
                $this->_maxHeight = $_maxHeight;
            }
        }
        if(isset($imagesNode['quality'])) {
            $_quality = intval($imagesNode['quality']);
            if($_quality>0 && $_quality<=100) {
                $this->_quality = $_quality;
            }
        }
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
