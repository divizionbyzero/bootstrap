<?php

if (!defined('IN_CKFINDER')) exit;




class CKFinder_Connector_CommandHandler_Thumbnail extends CKFinder_Connector_CommandHandler_CommandHandlerBase
{
    
    var $command = "Thumbnail";

    
    function sendResponse()
    {
                if (ob_get_level()) {
            while (@ob_end_clean() && ob_get_level());
        }
        header("Content-Encoding: none");

        $this->checkConnector();
        $this->checkRequest();

        $_config =& CKFinder_Connector_Core_Factory::getInstance("Core_Config");

        $_thumbnails = $_config->getThumbnailsConfig();
        if (!$_thumbnails->getIsEnabled()) {
            $this->_errorHandler->throwError(CKFINDER_CONNECTOR_ERROR_THUMBNAILS_DISABLED);
        }

        if (!$this->_currentFolder->checkAcl(CKFINDER_CONNECTOR_ACL_FILE_VIEW)) {
            $this->_errorHandler->throwError(CKFINDER_CONNECTOR_ERROR_UNAUTHORIZED);
        }

        if (!isset($_GET["FileName"])) {
            $this->_errorHandler->throwError(CKFINDER_CONNECTOR_ERROR_INVALID_REQUEST);
        }

        $fileName = CKFinder_Connector_Utils_FileSystem::convertToFilesystemEncoding($_GET["FileName"]);
        $_resourceTypeInfo = $this->_currentFolder->getResourceTypeConfig();

        if (!CKFinder_Connector_Utils_FileSystem::checkFileName($fileName)) {
            $this->_errorHandler->throwError(CKFINDER_CONNECTOR_ERROR_INVALID_REQUEST);
        }
        $sourceFilePath = CKFinder_Connector_Utils_FileSystem::combinePaths($this->_currentFolder->getServerPath(), $fileName);

        if ($_resourceTypeInfo->checkIsHiddenFile($fileName) || !file_exists($sourceFilePath)) {
            $this->_errorHandler->throwError(CKFINDER_CONNECTOR_ERROR_FILE_NOT_FOUND);
        }

        $thumbFilePath = CKFinder_Connector_Utils_FileSystem::combinePaths($this->_currentFolder->getThumbsServerPath(), $fileName);

                if (!file_exists($thumbFilePath)) {
            if(!$this->createThumb($sourceFilePath, $thumbFilePath, $_thumbnails->getMaxWidth(), $_thumbnails->getMaxHeight(), $_thumbnails->getQuality(), true, $_thumbnails->getBmpSupported())) {
                $this->_errorHandler->throwError(CKFINDER_CONNECTOR_ERROR_ACCESS_DENIED);
            }
        }

        $size = filesize($thumbFilePath);
        $sourceImageAttr = getimagesize($thumbFilePath);
        $mime = $sourceImageAttr["mime"];

        $rtime = isset($_SERVER["HTTP_IF_MODIFIED_SINCE"])?strtotime($_SERVER["HTTP_IF_MODIFIED_SINCE"]):0;
        $mtime =  filemtime($thumbFilePath);
        $etag = dechex($mtime) . "-" . dechex($size);

        $is304 = false;

        if (isset($_SERVER["HTTP_IF_NONE_MATCH"]) && $_SERVER["HTTP_IF_NONE_MATCH"] === $etag) {
            $is304 = true;
        }
        else if($rtime == $mtime) {
            $is304 = true;
        }

        if ($is304) {
            header("HTTP/1.0 304 Not Modified");
            exit();
        }

                                header('Cache-control: public');
        header('Etag: ' . $etag);
        header("Content-type: " . $mime . "; name=\"" . CKFinder_Connector_Utils_Misc::mbBasename($thumbFilePath) . "\"");
        header("Last-Modified: ".gmdate('D, d M Y H:i:s', $mtime) . " GMT");
                        header("Content-Length: ".$size);
        readfile($thumbFilePath);
        exit;
    }

    
    function createThumb($sourceFile, $targetFile, $maxWidth, $maxHeight, $quality, $preserverAspectRatio, $bmpSupported = false)
    {
        $sourceImageAttr = @getimagesize($sourceFile);
        if ($sourceImageAttr === false) {
            return false;
        }
        $sourceImageWidth = isset($sourceImageAttr[0]) ? $sourceImageAttr[0] : 0;
        $sourceImageHeight = isset($sourceImageAttr[1]) ? $sourceImageAttr[1] : 0;
        $sourceImageMime = isset($sourceImageAttr["mime"]) ? $sourceImageAttr["mime"] : "";
        $sourceImageBits = isset($sourceImageAttr["bits"]) ? $sourceImageAttr["bits"] : 8;
        $sourceImageChannels = isset($sourceImageAttr["channels"]) ? $sourceImageAttr["channels"] : 3;

        if (!$sourceImageWidth || !$sourceImageHeight || !$sourceImageMime) {
            return false;
        }

        $iFinalWidth = $maxWidth == 0 ? $sourceImageWidth : $maxWidth;
        $iFinalHeight = $maxHeight == 0 ? $sourceImageHeight : $maxHeight;

        if ($sourceImageWidth <= $iFinalWidth && $sourceImageHeight <= $iFinalHeight) {
            if ($sourceFile != $targetFile) {
                copy($sourceFile, $targetFile);
            }
            return true;
        }

        if ($preserverAspectRatio)
        {
                        $oSize = CKFinder_Connector_CommandHandler_Thumbnail::GetAspectRatioSize($iFinalWidth, $iFinalHeight, $sourceImageWidth, $sourceImageHeight );
        }
        else {
            $oSize = array('Width' => $iFinalWidth, 'Height' => $iFinalHeight);
        }

        CKFinder_Connector_Utils_Misc::setMemoryForImage($sourceImageWidth, $sourceImageHeight, $sourceImageBits, $sourceImageChannels);

        switch ($sourceImageAttr['mime'])
        {
            case 'image/gif':
                {
                    if (@imagetypes() & IMG_GIF) {
                        $oImage = @imagecreatefromgif($sourceFile);
                    } else {
                        $ermsg = 'GIF images are not supported';
                    }
                }
                break;
            case 'image/jpeg':
                {
                    if (@imagetypes() & IMG_JPG) {
                        $oImage = @imagecreatefromjpeg($sourceFile) ;
                    } else {
                        $ermsg = 'JPEG images are not supported';
                    }
                }
                break;
            case 'image/png':
                {
                    if (@imagetypes() & IMG_PNG) {
                        $oImage = @imagecreatefrompng($sourceFile) ;
                    } else {
                        $ermsg = 'PNG images are not supported';
                    }
                }
                break;
            case 'image/wbmp':
                {
                    if (@imagetypes() & IMG_WBMP) {
                        $oImage = @imagecreatefromwbmp($sourceFile);
                    } else {
                        $ermsg = 'WBMP images are not supported';
                    }
                }
                break;
            case 'image/bmp':
                {
                    
                    if ($bmpSupported && (@imagetypes() & IMG_JPG) && $sourceFile != $targetFile) {
                        $oImage = CKFinder_Connector_Utils_Misc::imageCreateFromBmp($sourceFile);
                    } else {
                        $ermsg = 'BMP/JPG images are not supported';
                    }
                }
                break;
            default:
                $ermsg = $sourceImageAttr['mime'].' images are not supported';
                break;
        }

        if (isset($ermsg) || false === $oImage) {
            return false;
        }


        $oThumbImage = imagecreatetruecolor($oSize["Width"], $oSize["Height"]);

        if (function_exists('imagesavealpha') && function_exists('imagecolorallocatealpha') && $sourceImageAttr['mime'] == 'image/png') {
            $bg = imagecolorallocatealpha($oThumbImage, 255, 255, 255, 127);             imagefill($oThumbImage, 0, 0 , $bg);
            imagealphablending($oThumbImage, false);
            imagesavealpha($oThumbImage, true);          }

                CKFinder_Connector_Utils_Misc::fastImageCopyResampled($oThumbImage, $oImage, 0, 0, 0, 0, $oSize["Width"], $oSize["Height"], $sourceImageWidth, $sourceImageHeight, (int)max(floor($quality/20), 6));

        switch ($sourceImageAttr['mime'])
        {
            case 'image/gif':
                imagegif($oThumbImage, $targetFile);
                break;
            case 'image/jpeg':
            case 'image/bmp':
                imagejpeg($oThumbImage, $targetFile, $quality);
                break;
            case 'image/png':
                imagepng($oThumbImage, $targetFile);
                break;
            case 'image/wbmp':
                imagewbmp($oThumbImage, $targetFile);
                break;
        }

        $_config =& CKFinder_Connector_Core_Factory::getInstance("Core_Config");
        if (file_exists($targetFile) && ($perms = $_config->getChmodFiles())) {
            $oldUmask = umask(0);
            chmod($targetFile, $perms);
            umask($oldUmask);
        }

        imageDestroy($oImage);
        imageDestroy($oThumbImage);

        return true;
    }



    
    function getAspectRatioSize($maxWidth, $maxHeight, $actualWidth, $actualHeight)
    {
        $oSize = array("Width"=>$maxWidth, "Height"=>$maxHeight);

                $iFactorX = (float)$maxWidth / (float)$actualWidth;
        $iFactorY = (float)$maxHeight / (float)$actualHeight;

                if ($iFactorX != 1 || $iFactorY != 1)
        {
                        if ($iFactorX < $iFactorY) {
                $oSize["Height"] = (int)round($actualHeight * $iFactorX);
            }
            else if ($iFactorX > $iFactorY) {
                $oSize["Width"] = (int)round($actualWidth * $iFactorY);
            }
        }

        if ($oSize["Height"] <= 0) {
            $oSize["Height"] = 1;
        }
        if ($oSize["Width"] <= 0) {
            $oSize["Width"] = 1;
        }

                return $oSize;
    }
}
