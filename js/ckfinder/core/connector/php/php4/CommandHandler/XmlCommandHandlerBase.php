<?php

if (!defined('IN_CKFINDER')) exit;




require_once CKFINDER_CONNECTOR_LIB_DIR . "/CommandHandler/CommandHandlerBase.php";

require_once CKFINDER_CONNECTOR_LIB_DIR . "/Core/Xml.php";


class CKFinder_Connector_CommandHandler_XmlCommandHandlerBase extends CKFinder_Connector_CommandHandler_CommandHandlerBase
{
    
    var $_connectorNode;

    
    function sendResponse()
    {
        $xml =& CKFinder_Connector_Core_Factory::getInstance("Core_Xml");
        $this->_connectorNode =& $xml->getConnectorNode();

        $this->checkConnector();
        if ($this->mustCheckRequest()) {
            $this->checkRequest();
        }

        $resourceTypeName = $this->_currentFolder->getResourceTypeName();
        if (!empty($resourceTypeName)) {
            $this->_connectorNode->addAttribute("resourceType", $this->_currentFolder->getResourceTypeName());
        }

        if ($this->mustAddCurrentFolderNode()) {
            $_currentFolder = new Ckfinder_Connector_Utils_XmlNode("CurrentFolder");
            $this->_connectorNode->addChild($_currentFolder);
            $_currentFolder->addAttribute("path", CKFinder_Connector_Utils_FileSystem::convertToConnectorEncoding($this->_currentFolder->getClientPath()));

            $this->_errorHandler->setCatchAllErros(true);
            $_url = $this->_currentFolder->getUrl();
            $_currentFolder->addAttribute("url", is_null($_url) ? "" : CKFinder_Connector_Utils_FileSystem::convertToConnectorEncoding($_url));
            $this->_errorHandler->setCatchAllErros(false);

            $_currentFolder->addAttribute("acl", $this->_currentFolder->getAclMask());
        }

        $this->buildXml();

        $_oErrorNode =& $xml->getErrorNode();
        $_oErrorNode->addAttribute("number", "0");

        echo $this->_connectorNode->asXML();
        exit;
    }

    
    function mustCheckRequest()
    {
        return true;
    }

    
    function mustAddCurrentFolderNode()
    {
        return true;
    }

    
    function buildXml()
    {

    }
}
