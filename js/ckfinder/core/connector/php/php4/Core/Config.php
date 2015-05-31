<?php

if (!defined('IN_CKFINDER')) exit;




require_once CKFINDER_CONNECTOR_LIB_DIR . "/Core/AccessControlConfig.php";

require_once CKFINDER_CONNECTOR_LIB_DIR . "/Core/ResourceTypeConfig.php";

require_once CKFINDER_CONNECTOR_LIB_DIR . "/Core/ThumbnailsConfig.php";

require_once CKFINDER_CONNECTOR_LIB_DIR . "/Core/ImagesConfig.php";


class CKFinder_Connector_Core_Config
{
    
    var $_isEnabled = false;
    
    var $_licenseName = "";
    
    var $_licenseKey = "";
    
    var $_roleSessionVar = "CKFinder_UserRole";
    
    var $_accessControlConfigCache;
    
    var $_resourceTypeConfigCache = array();
    
    var $_thumbnailsConfigCache;
    
    var $_imagesConfigCache;
    
    var $_defaultResourceTypes = array();
    
    var $_filesystemEncoding;
    
    var $_checkDoubleExtension = true;
    
    var $_secureImageUploads = true;
    
    var $_checkSizeAfterScaling = true;
    
    var $_htmlExtensions = array('html', 'htm', 'xml', 'xsd', 'txt', 'js');
    
    var $_chmodFiles = 0777;
    
    var $_chmodFolders = 0755;
    
    var $_hideFolders = array(".svn", "CVS");
    
    var $_hideFiles = array(".*");
    
    var $_forceAscii = false;

    function CKFinder_Connector_Core_Config()
    {
        $this->loadValues();
    }

    
    function getFilesystemEncoding()
    {
        return $this->_filesystemEncoding;
    }

    
    function getSecureImageUploads()
    {
        return $this->_secureImageUploads;
    }

    
    function checkSizeAfterScaling()
    {
        return $this->_checkSizeAfterScaling;
    }

    
    function getHtmlExtensions()
    {
        return $this->_htmlExtensions;
    }

    
    function forceAscii()
    {
        return $this->_forceAscii;
    }

    
    function getHideFoldersRegex()
    {
        static $folderRegex;

        if (!isset($folderRegex)) {
            if (is_array($this->_hideFolders) && $this->_hideFolders) {
                $folderRegex = join("|", $this->_hideFolders);
                $folderRegex = strtr($folderRegex, array("?" => "__QMK__", "*" => "__AST__", "|" => "__PIP__"));
                $folderRegex = preg_quote($folderRegex, "/");
                $folderRegex = strtr($folderRegex, array("__QMK__" => ".", "__AST__" => ".*", "__PIP__" => "|"));
                $folderRegex = "/^(?:" . $folderRegex . ")$/uim";
            }
            else {
                $folderRegex = "";
            }
        }

        return $folderRegex;
    }

    
    function getHideFilesRegex()
    {
        static $fileRegex;

        if (!isset($fileRegex)) {
            if (is_array($this->_hideFiles) && $this->_hideFiles) {
                $fileRegex = join("|", $this->_hideFiles);
                $fileRegex = strtr($fileRegex, array("?" => "__QMK__", "*" => "__AST__", "|" => "__PIP__"));
                $fileRegex = preg_quote($fileRegex, "/");
                $fileRegex = strtr($fileRegex, array("__QMK__" => ".", "__AST__" => ".*", "__PIP__" => "|"));
                $fileRegex = "/^(?:" . $fileRegex . ")$/uim";
            }
            else {
                $fileRegex = "";
            }
        }

        return $fileRegex;
    }

    
    function getCheckDoubleExtension()
    {
        return $this->_checkDoubleExtension;
    }

    
    function getDefaultResourceTypes()
    {
        return $this->_defaultResourceTypes;
    }

    
    function getIsEnabled()
    {
        return $this->_isEnabled;
    }

    
    function getLicenseKey()
    {
        return $this->_licenseKey;
    }

    
    function getLicenseName()
    {
        return $this->_licenseName;
    }

    
    function getChmodFiles()
    {
        return $this->_chmodFiles;
    }

    
    function getChmodFolders()
    {
        return $this->_chmodFolders;
    }

    
    function getRoleSessionVar()
    {
        return $this->_roleSessionVar;
    }

    
    function &getResourceTypeConfig($resourceTypeName)
    {
        $_null = null;

        if (isset($this->_resourceTypeConfigCache[$resourceTypeName])) {
            return $this->_resourceTypeConfigCache[$resourceTypeName];
        }

        if (!isset($GLOBALS['config']['ResourceType']) || !is_array($GLOBALS['config']['ResourceType'])) {
            return $_null;
        }

        reset($GLOBALS['config']['ResourceType']);
        while (list($_key,$_resourceTypeNode) = each($GLOBALS['config']['ResourceType'])) {
            if ($_resourceTypeNode['name'] === $resourceTypeName) {
                $this->_resourceTypeConfigCache[$resourceTypeName] = new CKFinder_Connector_Core_ResourceTypeConfig($_resourceTypeNode);

                return $this->_resourceTypeConfigCache[$resourceTypeName];
            }
        }

        return $_null;
    }

    
    function &getThumbnailsConfig()
    {
        if (!isset($this->_thumbnailsConfigCache)) {
            $this->_thumbnailsConfigCache = new CKFinder_Connector_Core_ThumbnailsConfig(isset($GLOBALS['config']['Thumbnails']) ? $GLOBALS['config']['Thumbnails'] : array());
        }

        return $this->_thumbnailsConfigCache;
    }

    
    function &getImagesConfig()
    {
        if (!isset($this->_imagesConfigCache)) {
            $this->_imagesConfigCache = new CKFinder_Connector_Core_ImagesConfig(isset($GLOBALS['config']['Images']) ? $GLOBALS['config']['Images'] : array());
        }

        return $this->_imagesConfigCache;
    }

    
    function &getAccessControlConfig()
    {
        if (!isset($this->_accessControlConfigCache)) {
            $this->_accessControlConfigCache = new CKFinder_Connector_Core_AccessControlConfig(isset($GLOBALS['config']['AccessControl']) ? $GLOBALS['config']['AccessControl'] : array());
        }

        return $this->_accessControlConfigCache;
    }

    
    function loadValues()
    {
        if (function_exists('CheckAuthentication')) {
            $this->_isEnabled = CheckAuthentication();
        }
        if (isset($GLOBALS['config']['LicenseName'])) {
            $this->_licenseName = (string)$GLOBALS['config']['LicenseName'];
        }
        if (isset($GLOBALS['config']['LicenseKey'])) {
            $this->_licenseKey = (string)$GLOBALS['config']['LicenseKey'];
        }
        if (isset($GLOBALS['config']['FilesystemEncoding'])) {
            $this->_filesystemEncoding = (string)$GLOBALS['config']['FilesystemEncoding'];
        }
        if (isset($GLOBALS['config']['RoleSessionVar'])) {
            $this->_roleSessionVar = (string)$GLOBALS['config']['RoleSessionVar'];
        }
        if (isset($GLOBALS['config']['CheckDoubleExtension'])) {
            $this->_checkDoubleExtension = CKFinder_Connector_Utils_Misc::booleanValue($GLOBALS['config']['CheckDoubleExtension']);
        }
        if (isset($GLOBALS['config']['SecureImageUploads'])) {
            $this->_secureImageUploads = CKFinder_Connector_Utils_Misc::booleanValue($GLOBALS['config']['SecureImageUploads']);
        }
        if (isset($GLOBALS['config']['CheckSizeAfterScaling'])) {
            $this->_checkSizeAfterScaling = CKFinder_Connector_Utils_Misc::booleanValue($GLOBALS['config']['CheckSizeAfterScaling']);
        }
        if (isset($GLOBALS['config']['ForceAscii'])) {
            $this->_forceAscii = CKFinder_Connector_Utils_Misc::booleanValue($GLOBALS['config']['ForceAscii']);
        }
        if (isset($GLOBALS['config']['HtmlExtensions'])) {
            $this->_htmlExtensions = (array)$GLOBALS['config']['HtmlExtensions'];
        }
        if (isset($GLOBALS['config']['HideFolders'])) {
            $this->_hideFolders = (array)$GLOBALS['config']['HideFolders'];
        }
        if (isset($GLOBALS['config']['HideFiles'])) {
            $this->_hideFiles = (array)$GLOBALS['config']['HideFiles'];
        }
        if (isset($GLOBALS['config']['ChmodFiles'])) {
            $this->_chmodFiles = $GLOBALS['config']['ChmodFiles'];
        }
        if (isset($GLOBALS['config']['ChmodFolders'])) {
            $this->_chmodFolders = $GLOBALS['config']['ChmodFolders'];
        }
        if (isset($GLOBALS['config']['DefaultResourceTypes'])) {
            $_defaultResourceTypes = (string)$GLOBALS['config']['DefaultResourceTypes'];
            if (strlen($_defaultResourceTypes)) {
                $this->_defaultResourceTypes = explode(",", $_defaultResourceTypes);
            }
        }
    }

    
    function getResourceTypeNames()
    {
        if (!isset($GLOBALS['config']['ResourceType']) || !is_array($GLOBALS['config']['ResourceType'])) {
            return array();
        }

        $_names = array();
        foreach ($GLOBALS['config']['ResourceType'] as $key => $_resourceType) {
            if (isset($_resourceType['name'])) {
                $_names[] = (string)$_resourceType['name'];
            }
        }

        return $_names;
    }
}
