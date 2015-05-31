<?php

if (!defined('IN_CKFINDER')) exit;




require_once CKFINDER_CONNECTOR_LIB_DIR . "/Utils/XmlNode.php";


class CKFinder_Connector_Core_Xml
{
    
    var $_connectorNode;
    
    var $_errorNode;

    function CKFinder_Connector_Core_Xml()
    {
        $this->sendXmlHeaders();
        echo $this->getXMLDeclaration();
        $this->_connectorNode = new Ckfinder_Connector_Utils_XmlNode("Connector");
        $this->_errorNode = new Ckfinder_Connector_Utils_XmlNode("Error");
        $this->_connectorNode->addChild($this->_errorNode);
    }

    
    function &getConnectorNode()
    {
    	return $this->_connectorNode;
    }

    
    function &getErrorNode()
    {
    	return $this->_errorNode;
    }

    
    function sendXmlHeaders()
    {
                        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT') ;
                header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT') ;
                header('Cache-Control: no-store, no-cache, must-revalidate') ;
        header('Cache-Control: post-check=0, pre-check=0', false) ;
                header('Pragma: no-cache') ;

                header( 'Content-Type:text/xml; charset=utf-8' ) ;
    }

    
    function getXMLDeclaration()
    {
    	return '<?xml version="1.0" encoding="utf-8"?>';
    }

    
    function raiseError( $number, $text = false)
    {
        $this->_errorNode->addAttribute("number", intval($number));
        if (false!=$text) {
            $this->_errorNode->addAttribute("text", $text);
        }

        echo $this->_connectorNode->asXML();
    }
}
