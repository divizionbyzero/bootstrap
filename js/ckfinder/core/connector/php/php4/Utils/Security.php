<?php

if (!defined('IN_CKFINDER')) exit;




class CKFinder_Connector_Utils_Security
{

    
    function getRidOfMagicQuotes()
    {
        if (get_magic_quotes_gpc()) {
            if (!empty($_GET)) {
                $this->stripQuotes($_GET);
            }
            if (!empty($_POST)) {
                $this->stripQuotes($_POST);
            }
            if (!empty($_COOKIE)) {
                $this->stripQuotes($_COOKIE);
            }
            if (!empty($_FILES)) {
                while (list($k,$v) = each($_FILES)) {
                    if (isset($_FILES[$k]['name'])) {
                        $this->stripQuotes($_FILES[$k]['name']);
                    }
                }
            }
        }
    }

    
    function stripQuotes(&$var, $depth=0, $howDeep=5)
    {
        if (is_array($var)) {
            if ($depth++<$howDeep) {
                while (list($k,$v) = each($var)) {
                    $this->stripQuotes($var[$k], $depth, $howDeep);
                }
            }
        } else {
            $var = stripslashes($var);
        }
    }
}
