<?php

if (!defined('IN_CKFINDER')) exit;




class CKFinder_Connector_Core_ResourceTypeConfig
{
    
    var $_name = "";
    
    var $_url = "";
    
    var $_directory = "";
    
    var $_maxSize = 0;
    
    var $_allowedExtensions = array();
    
    var $_deniedExtensions = array();
    
    var $_config;

    
    function CKFinder_Connector_Core_ResourceTypeConfig($resourceTypeNode)
    {
        if (isset($resourceTypeNode["name"])) {
            $this->_name = $resourceTypeNode["name"];
        }

        if (isset($resourceTypeNode["url"])) {
            $this->_url = $resourceTypeNode["url"];
        }

        if (!strlen($this->_url)) {
            $this->_url = "/";
        }
        else if(substr($this->_url,-1,1) != "/") {
            $this->_url .= "/";
        }

        if (isset($resourceTypeNode["maxSize"])) {
            $this->_maxSize = CKFinder_Connector_Utils_Misc::returnBytes((string)$resourceTypeNode["maxSize"]);
        }

        if (isset($resourceTypeNode["directory"])) {
            $this->_directory = $resourceTypeNode["directory"];
        }

        if (!strlen($this->_directory)) {
            $this->_directory = resolveUrl($this->_url);
        }

        if (isset($resourceTypeNode["allowedExtensions"])) {
            if (is_array($resourceTypeNode["allowedExtensions"])) {
                foreach ($resourceTypeNode["allowedExtensions"] as $e) {
                    $this->_allowedExtensions[] = strtolower(trim((string)$e));
                }
            }
            else {
                $resourceTypeNode["allowedExtensions"] = trim((string)$resourceTypeNode["allowedExtensions"]);
                if (strlen($resourceTypeNode["allowedExtensions"])) {
                    $extensions = explode(",", $resourceTypeNode["allowedExtensions"]);
                    foreach ($extensions as $e) {
                        $this->_allowedExtensions[] = strtolower(trim($e));
                    }
                }
            }
        }

        if (isset($resourceTypeNode["deniedExtensions"])) {
            if (is_array($resourceTypeNode["deniedExtensions"])) {

                foreach ($resourceTypeNode["deniedExtensions"] as $extension) {
                    $this->_deniedExtensions[] = strtolower(trim((string)$e));
                }
            }
            else {
                $resourceTypeNode["deniedExtensions"] = trim((string)$resourceTypeNode["deniedExtensions"]);
                if (strlen($resourceTypeNode["deniedExtensions"])) {
                    $extensions = explode(",", $resourceTypeNode["deniedExtensions"]);
                    foreach ($extensions as $e) {
                        $this->_deniedExtensions[] = strtolower(trim($e));
                    }
                }
            }
        }
    }

    
    function getName()
    {
        return $this->_name;
    }

    
    function getUrl()
    {
        return $this->_url;
    }

    
    function getDirectory()
    {
        return $this->_directory;
    }

    
    function getMaxSize()
    {
        return $this->_maxSize;
    }

    
    function getAllowedExtensions()
    {
        return $this->_allowedExtensions;
    }

    
    function getDeniedExtensions()
    {
        return $this->_deniedExtensions;
    }

    
    function checkExtension(&$fileName, $renameIfRequired = true)
    {
        if (strpos($fileName, '.') === false) {
            return true;
        }

        if (is_null($this->_config)) {
            $this->_config =& CKFinder_Connector_Core_Factory::getInstance("Core_Config");
        }

        $toCheck = array();

        if ($this->_config->getCheckDoubleExtension()) {
            $pieces = explode('.', $fileName);

                        if ( !$this->checkSingleExtension( $pieces[sizeof($pieces)-1] ) ) {
                return false;
            }

            if ($renameIfRequired) {
                                                $fileName = $pieces[0] ;
                for ($i=1; $i<sizeof($pieces)-1; $i++) {
                    $fileName .= $this->checkSingleExtension( $pieces[$i] ) ? '.' : '_' ;
                    $fileName .= $pieces[$i];
                }

                                $fileName .= '.' . $pieces[sizeof($pieces)-1] ;
            }
        }
        else {
                        return $this->checkSingleExtension( substr($fileName, strrpos($fileName,'.')+1) );
        }

        return true;
    }

    
    function checkIsHiddenFolder($folderName)
    {
        if (is_null($this->_config)) {
            $this->_config =& CKFinder_Connector_Core_Factory::getInstance("Core_Config");
        }

        $regex = $this->_config->getHideFoldersRegex();
        if ($regex) {
            return preg_match($regex, $folderName);
        }

        return false;
    }

    
    function checkIsHiddenFile($fileName)
    {
        if (is_null($this->_config)) {
            $this->_config =& CKFinder_Connector_Core_Factory::getInstance("Core_Config");
        }

        $regex = $this->_config->getHideFilesRegex();
        if ($regex) {
            return preg_match($regex, $fileName);
        }

        return false;
    }

    
    function checkIsHiddenPath($path)
    {
        $_clientPathParts = explode("/", trim($path, "/"));
        if ($_clientPathParts) {
            foreach ($_clientPathParts as $_part) {
                if ($this->checkIsHiddenFolder($_part)) {
                    return true;
                }
            }
        }

        return false;
    }

    function checkSingleExtension($extension)
    {
        $extension = strtolower(ltrim($extension,'.'));

        if (sizeof($this->_deniedExtensions)) {
            if (in_array($extension, $this->_deniedExtensions)) {
                return false;
            }
        }

        if (sizeof($this->_allowedExtensions)) {
            return in_array($extension, $this->_allowedExtensions);
        }

        return true;
    }
}
