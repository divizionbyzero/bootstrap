<?php

if (!defined('IN_CKFINDER')) exit;




class Ckfinder_Connector_Utils_XmlNode
{
    
    var $_attributes = array();
    
    var $_childNodes = array();
    
    var $_name;
    
    var $_value;

    
    function Ckfinder_Connector_Utils_XmlNode($nodeName, $nodeValue = null)
    {
        $this->_name = $nodeName;
        if (!is_null($nodeValue)) {
            $this->_value = $nodeValue;
        }
    }

    function &getChild($name)
    {
        foreach ($this->_childNodes as $i => $node) {
            if ($node->_name == $name) {
                return $this->_childNodes[$i];
            }
        }
        return null;
    }

    
    function addAttribute($name, $value)
    {
        $this->_attributes[$name] = $value;
    }

    
    function getAttribute($name)
    {
        return $this->_attributes[$name];
    }

    
    function setValue($value)
    {
        $this->_value = $value;
    }

    
    function getValue()
    {
        return $this->_value;
    }

    
    function addChild(&$node)
    {
        $this->_childNodes[] =& $node;
    }

    
    function asXML()
    {
        $ret = "<" . $this->_name;

                if (sizeof($this->_attributes)>0) {
            foreach ($this->_attributes as $_name => $_value) {
                $ret .= " " . $_name . '="' . htmlspecialchars($_value) . '"';
            }
        }

                if (is_null($this->_value) && !sizeof($this->_childNodes)) {
            $ret .= " />";
            return $ret;
        }

                $ret .= ">";

                if (!is_null($this->_value)) {
            $ret .= htmlspecialchars($this->_value);
        }

                if (sizeof($this->_childNodes)>0) {
            foreach ($this->_childNodes as $_node) {
                $ret .= $_node->asXml();
            }
        }

        $ret .= "</" . $this->_name . ">";

        return $ret;
    }
}
