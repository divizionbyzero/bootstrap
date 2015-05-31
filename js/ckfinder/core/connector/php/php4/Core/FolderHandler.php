<?php

if (!defined('IN_CKFINDER')) exit;




require_once CKFINDER_CONNECTOR_LIB_DIR . "/Utils/FileSystem.php";


class CKFinder_Connector_Core_FolderHandler
{
    
    var $_resourceTypeConfig;
    
    var $_resourceTypeName = "";
    
    var $_clientPath = "/";
    
    var $_url;
    
    var $_serverPath;
    
    var $_thumbsServerPath;
    
    var $_aclMask;
    
    var $_folderInfo;
    
    var $_thumbsFolderInfo;

    function CKFinder_Connector_Core_FolderHandler()
    {
        if (isset($_GET["type"])) {
            $this->_resourceTypeName = (string)$_GET["type"];
        }

        if (isset($_GET["currentFolder"])) {
            $this->_clientPath = CKFinder_Connector_Utils_FileSystem::convertToFilesystemEncoding((string)$_GET["currentFolder"]);
        }

        if (!strlen($this->_clientPath)) {
            $this->_clientPath = "/";
        }
        else {
            if (substr($this->_clientPath, -1, 1) != "/") {
                $this->_clientPath .= "/";
            }
            if (substr($this->_clientPath, 0, 1) != "/") {
                $this->_clientPath = "/" . $this->_clientPath;
            }
        }

        $this->_aclMask = -1;
    }

    
    function &getResourceTypeConfig()
    {
        if (!isset($this->_resourceTypeConfig)) {
            $_config =& CKFinder_Connector_Core_Factory::getInstance("Core_Config");
            $this->_resourceTypeConfig = $_config->getResourceTypeConfig($this->_resourceTypeName);
        }

        if (is_null($this->_resourceTypeConfig)) {
            $connector =& CKFinder_Connector_Core_Factory::getInstance("Core_Connector");
            $oErrorHandler =& $connector->getErrorHandler();
            $oErrorHandler->throwError(CKFINDER_CONNECTOR_ERROR_INVALID_TYPE);
        }

        return $this->_resourceTypeConfig;
    }

    
    function getResourceTypeName()
    {
        return $this->_resourceTypeName;
    }

    
    function getClientPath()
    {
        return $this->_clientPath;
    }

    
    function getUrl()
    {
        if (is_null($this->_url)) {
            $this->_resourceTypeConfig = $this->getResourceTypeConfig();
            if (is_null($this->_resourceTypeConfig)) {
                $connector =& CKFinder_Connector_Core_Factory::getInstance("Core_Connector");
                $oErrorHandler =& $connector->getErrorHandler();
                $oErrorHandler->throwError(CKFINDER_CONNECTOR_ERROR_INVALID_TYPE);
                $this->_url = "";
            }
            else {
                $this->_url = $this->_resourceTypeConfig->getUrl() . ltrim($this->getClientPath(), "/");
            }
        }

        return $this->_url;
    }

    
    function getServerPath()
    {
        if (is_null($this->_serverPath)) {
            $this->_resourceTypeConfig = $this->getResourceTypeConfig();
            $this->_serverPath = CKFinder_Connector_Utils_FileSystem::combinePaths($this->_resourceTypeConfig->getDirectory(), ltrim($this->_clientPath, "/"));
        }

        return $this->_serverPath;
    }

    
    function getThumbsServerPath()
    {
        if (is_null($this->_thumbsServerPath)) {
            $this->_resourceTypeConfig = $this->getResourceTypeConfig();

            $_config =& CKFinder_Connector_Core_Factory::getInstance("Core_Config");
            $_thumbnailsConfig = $_config->getThumbnailsConfig();

                        $this->_thumbsServerPath = CKFinder_Connector_Utils_FileSystem::combinePaths($_thumbnailsConfig->getDirectory(), $this->_resourceTypeConfig->getName());

                        $this->_thumbsServerPath = CKFinder_Connector_Utils_FileSystem::combinePaths($this->_thumbsServerPath, ltrim($this->_clientPath, '/'));

            if (!is_dir($this->_thumbsServerPath)) {
                if(!CKFinder_Connector_Utils_FileSystem::createDirectoryRecursively($this->_thumbsServerPath)) {
                    
                }
            }
        }

        return $this->_thumbsServerPath;
    }

    
    function getAclMask()
    {
        $_config =& CKFinder_Connector_Core_Factory::getInstance("Core_Config");
        $_aclConfig = $_config->getAccessControlConfig();

        if ($this->_aclMask == -1) {
            $this->_aclMask = $_aclConfig->getComputedMask($this->_resourceTypeName, $this->_clientPath);
        }

        return $this->_aclMask;
    }

    
    function checkAcl($aclToCkeck)
    {
        $aclToCkeck = intval($aclToCkeck);

        $maska = $this->getAclMask();
        return (($maska & $aclToCkeck) == $aclToCkeck);
    }
}
