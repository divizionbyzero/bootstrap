<?php

if (!defined('IN_CKFINDER')) exit;




require_once CKFINDER_CONNECTOR_LIB_DIR . "/CommandHandler/XmlCommandHandlerBase.php";


class CKFinder_Connector_CommandHandler_MoveFiles extends CKFinder_Connector_CommandHandler_XmlCommandHandlerBase
{
    
    var $command = "MoveFiles";


    
    function buildXml()
    {
        if (empty($_POST['CKFinderCommand']) || $_POST['CKFinderCommand'] != 'true') {
            $this->_errorHandler->throwError(CKFINDER_CONNECTOR_ERROR_INVALID_REQUEST);
        }

        $clientPath = $this->_currentFolder->getClientPath();
        $sServerDir = $this->_currentFolder->getServerPath();
        $currentResourceTypeConfig = $this->_currentFolder->getResourceTypeConfig();
        $_config =& CKFinder_Connector_Core_Factory::getInstance("Core_Config");
        $_aclConfig = $_config->getAccessControlConfig();
        $aclMasks = array();
        $_resourceTypeConfig = array();

        if (!$this->_currentFolder->checkAcl(CKFINDER_CONNECTOR_ACL_FILE_RENAME | CKFINDER_CONNECTOR_ACL_FILE_UPLOAD | CKFINDER_CONNECTOR_ACL_FILE_DELETE)) {
            $this->_errorHandler->throwError(CKFINDER_CONNECTOR_ERROR_UNAUTHORIZED);
        }

                $oErrorsNode = new CKFinder_Connector_Utils_XmlNode("Errors");
        $errorCode = CKFINDER_CONNECTOR_ERROR_NONE;
        $moved = 0;
        $movedAll = 0;
        if (!empty($_POST['moved'])) {
            $movedAll = intval($_POST['moved']);
        }
        $checkedPaths = array();

        $oMoveFilesNode = new Ckfinder_Connector_Utils_XmlNode("MoveFiles");

        if (!empty($_POST['files']) && is_array($_POST['files'])) {
            foreach ($_POST['files'] as $index => $arr) {
                if (empty($arr['name'])) {
                    continue;
                }
                if (!isset($arr['name'], $arr['type'], $arr['folder'])) {
                    $this->_errorHandler->throwError(CKFINDER_CONNECTOR_ERROR_INVALID_REQUEST);
                }

                                $name = CKFinder_Connector_Utils_FileSystem::convertToFilesystemEncoding($arr['name']);
                                $type = $arr['type'];
                                $path = CKFinder_Connector_Utils_FileSystem::convertToFilesystemEncoding($arr['folder']);
                                $options = (!empty($arr['options'])) ? $arr['options'] : '';

                $destinationFilePath = $sServerDir.$name;

                                if (!CKFinder_Connector_Utils_FileSystem::checkFileName($name) || preg_match(CKFINDER_REGEX_INVALID_PATH, $path)) {
                    $this->_errorHandler->throwError(CKFINDER_CONNECTOR_ERROR_INVALID_REQUEST);
                }

                                if (!isset($_resourceTypeConfig[$type])) {
                    $_resourceTypeConfig[$type] = $_config->getResourceTypeConfig($type);
                }

                                if (is_null($_resourceTypeConfig[$type])) {
                    $this->_errorHandler->throwError(CKFINDER_CONNECTOR_ERROR_INVALID_REQUEST);
                }

                                if (!$_resourceTypeConfig[$type]->checkExtension($name, false)) {
                    $errorCode = CKFINDER_CONNECTOR_ERROR_INVALID_EXTENSION;
                    $this->appendErrorNode($oErrorsNode, $errorCode, $name, $type, $path);
                    continue;
                }

                                if ($currentResourceTypeConfig->getName() != $type) {
                    if (!$currentResourceTypeConfig->checkExtension($name, false)) {
                        $errorCode = CKFINDER_CONNECTOR_ERROR_INVALID_EXTENSION;
                        $this->appendErrorNode($oErrorsNode, $errorCode, $name, $type, $path);
                        continue;
                    }
                }

                                                if (empty($checkedPaths[$path])) {
                    $checkedPaths[$path] = true;

                    if ($_resourceTypeConfig[$type]->checkIsHiddenPath($path)) {
                        $this->_errorHandler->throwError(CKFINDER_CONNECTOR_ERROR_INVALID_REQUEST);
                    }
                }

                $sourceFilePath = $_resourceTypeConfig[$type]->getDirectory().$path.$name;

                                if ($currentResourceTypeConfig->checkIsHiddenFile($name)) {
                    $this->_errorHandler->throwError(CKFINDER_CONNECTOR_ERROR_INVALID_REQUEST);
                }

                                if (!isset($aclMasks[$type."@".$path])) {
                    $aclMasks[$type."@".$path] = $_aclConfig->getComputedMask($type, $path);
                }

                $isAuthorized = (($aclMasks[$type."@".$path] & CKFINDER_CONNECTOR_ACL_FILE_VIEW) == CKFINDER_CONNECTOR_ACL_FILE_VIEW);
                if (!$isAuthorized) {
                    $this->_errorHandler->throwError(CKFINDER_CONNECTOR_ERROR_UNAUTHORIZED);
                }

                                if (!file_exists($sourceFilePath) || !is_file($sourceFilePath)) {
                    $errorCode = CKFINDER_CONNECTOR_ERROR_FILE_NOT_FOUND;
                    $this->appendErrorNode($oErrorsNode, $errorCode, $name, $type, $path);
                    continue;
                }

                                if ($currentResourceTypeConfig->getName() != $type) {
                    $maxSize = $currentResourceTypeConfig->getMaxSize();
                    $fileSize = filesize($sourceFilePath);
                    if ($maxSize && $fileSize>$maxSize) {
                        $errorCode = CKFINDER_CONNECTOR_ERROR_UPLOADED_TOO_BIG;
                        $this->appendErrorNode($oErrorsNode, $errorCode, $name, $type, $path);
                        continue;
                    }
                }

                                                                if ($sourceFilePath == $destinationFilePath) {
                    $errorCode = CKFINDER_CONNECTOR_ERROR_SOURCE_AND_TARGET_PATH_EQUAL;
                    $this->appendErrorNode($oErrorsNode, $errorCode, $name, $type, $path);
                    continue;
                }
                                else if (file_exists($destinationFilePath)) {
                    if (strpos($options, "overwrite") !== false) {
                        if (!@unlink($destinationFilePath)) {
                            $errorCode = CKFINDER_CONNECTOR_ERROR_ACCESS_DENIED;
                            $this->appendErrorNode($oErrorsNode, $errorCode, $name, $type, $path);
                            continue;
                        }
                        else {
                            if (!@rename($sourceFilePath, $destinationFilePath)) {
                                $errorCode = CKFINDER_CONNECTOR_ERROR_ACCESS_DENIED;
                                $this->appendErrorNode($oErrorsNode, $errorCode, $name, $type, $path);
                                continue;
                            }
                            else {
                                $moved++;
                            }
                        }
                    }
                    else if (strpos($options, "autorename") !== false) {
                        $iCounter = 1;
                        while (true)
                        {
                            $fileName = CKFinder_Connector_Utils_FileSystem::getFileNameWithoutExtension($name) .
                                "(" . $iCounter . ")" . "." .
                                CKFinder_Connector_Utils_FileSystem::getExtension($name);

                            $destinationFilePath = $sServerDir.$fileName;
                            if (!file_exists($destinationFilePath)) {
                                break;
                            }
                            else {
                                $iCounter++;
                            }
                        }
                        if (!@rename($sourceFilePath, $destinationFilePath)) {
                            $errorCode = CKFINDER_CONNECTOR_ERROR_ACCESS_DENIED;
                            $this->appendErrorNode($oErrorsNode, $errorCode, $name, $type, $path);
                            continue;
                        }
                        else {
                            $moved++;
                        }
                    }
                    else {
                        $errorCode = CKFINDER_CONNECTOR_ERROR_ALREADY_EXIST;
                        $this->appendErrorNode($oErrorsNode, $errorCode, $name, $type, $path);
                        continue;
                    }
                }
                else {
                    if (!@rename($sourceFilePath, $destinationFilePath)) {
                        $errorCode = CKFINDER_CONNECTOR_ERROR_ACCESS_DENIED;
                        $this->appendErrorNode($oErrorsNode, $errorCode, $name, $type, $path);
                        continue;
                    }
                    else {
                        $moved++;
                    }
                }
            }
        }

        $this->_connectorNode->addChild($oMoveFilesNode);
        if ($errorCode != CKFINDER_CONNECTOR_ERROR_NONE) {
            $this->_connectorNode->addChild($oErrorsNode);
        }
        $oMoveFilesNode->addAttribute("moved", $moved);
        $oMoveFilesNode->addAttribute("movedTotal", $movedAll + $moved);

        
        if ($errorCode != CKFINDER_CONNECTOR_ERROR_NONE) {
            $this->_errorHandler->throwError(CKFINDER_CONNECTOR_ERROR_MOVE_FAILED);
        }
    }

    function appendErrorNode(&$oErrorsNode, $errorCode, $name, $type, $path)
    {
        $oErrorNode = new CKFinder_Connector_Utils_XmlNode("Error");
        $oErrorNode->addAttribute("code", $errorCode);
        $oErrorNode->addAttribute("name", CKFinder_Connector_Utils_FileSystem::convertToConnectorEncoding($name));
        $oErrorNode->addAttribute("type", $type);
        $oErrorNode->addAttribute("folder", $path);
        $oErrorsNode->addChild($oErrorNode);
    }
}
