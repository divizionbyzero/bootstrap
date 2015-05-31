<?php

if (!defined('IN_CKFINDER')) exit;


class CKFinder_Connector_Core_Hooks
{

    
    function run($event, $args = array())
    {
        $config = $GLOBALS['config'];
        if (!isset($config['Hooks'])) {
            return true;
        }
        $hooks =& $config['Hooks'];

        if (!is_array($hooks) || !array_key_exists($event, $hooks) || !is_array($hooks[$event])) {
            return true;
        }

        $errorHandler = $GLOBALS['connector']->getErrorHandler();

        foreach ($hooks[$event] as $i => $hook) {

            $object = NULL;
            $method = NULL;
            $function = NULL;
            $data = NULL;
            $passData = false;

            
                        if (is_string($hook)) {
                $function = $hook;
            }
                        else if (is_object($hook)) {
                $object = $hooks[$event][$i];
                $method = "on" . $event;
            }
                        else if (is_array($hook)) {
                $count = count($hook);
                if ($count) {
                                        if (is_object($hook[0])) {
                        $object = $hooks[$event][$i][0];
                        if ($count < 2) {
                            $method = "on" . $event;
                        } else {
                                                        $method = $hook[1];
                            if (count($hook) > 2) {
                                                                $passData = true;
                                $data = $hook[2];
                            }
                        }
                    }
                                        else if (is_string($hook[0])) {
                        $function = $hook[0];
                        if ($count > 1) {
                                                        $passData = true;
                            $data = $hook[1];
                        }
                    }
                }
            }

            
            if ($passData) {
                $args = array_merge(array($data), $args);
            }

            if (isset($object)) {
                $callback = array($object, $method);
            }
            else if (false !== ($pos = strpos($function, '::'))) {
                $callback = array(substr($function, 0, $pos), substr($function, $pos + 2));
            }
            else {
                $callback = $function;
            }

            if (is_callable($callback)) {
                $ret = call_user_func_array($callback, $args);
            }
            else {
                $functionName = CKFinder_Connector_Core_Hooks::_printCallback($callback);
                $errorHandler->throwError(CKFINDER_CONNECTOR_ERROR_CUSTOM_ERROR,
                "CKFinder failed to call a hook: " . $functionName);
                return false;
            }

                        if (is_string($ret)) {
                $errorHandler->throwError(CKFINDER_CONNECTOR_ERROR_CUSTOM_ERROR, $ret);
                return false;
            }
                                                                        else if (is_int($ret)) {
                $errorHandler->throwError($ret);
                return false;
            }
                        else if( $ret === null ) {
                $functionName = CKFinder_Connector_Core_Hooks::_printCallback($callback);
                $errorHandler->throwError(CKFINDER_CONNECTOR_ERROR_CUSTOM_ERROR,
                "CKFinder extension returned an invalid value (null)." .
                "Hook " . $functionName . " should return a value.");
                return false;
            }
            else if (!$ret) {
                return false;
            }
        }

        return true;
    }

    
    function _printCallback($callback)
    {
        if (is_array($callback)) {
            if (is_object($callback[0])) {
                $className = get_class($callback[0]);
            } else {
                $className = strval($callback[0]);
            }
            $functionName = $className . '::' . strval($callback[1]);
        }
        else {
            $functionName = strval($callback);
        }
        return $functionName;
    }
}
