<?php

if (!defined('IN_CKFINDER')) exit;




class CKFinder_Connector_Utils_Misc
{
    function getErrorMessage($number, $arg = "") {
        $langCode = 'en';
        if (!empty($_GET['langCode']) && preg_match("/^[a-z\-]+$/", $_GET['langCode'])) {
            if (file_exists(CKFINDER_CONNECTOR_LANG_PATH . "/" . $_GET['langCode'] . ".php"))
                $langCode = $_GET['langCode'];
        }
        include CKFINDER_CONNECTOR_LANG_PATH . "/" . $langCode . ".php";
        if ($number) {
            if (!empty ($GLOBALS['CKFLang']['Errors'][$number])) {
                $errorMessage = str_replace("%1", $arg, $GLOBALS['CKFLang']['Errors'][$number]);
            } else {
                $errorMessage = str_replace("%1", $number, $GLOBALS['CKFLang']['ErrorUnknown']);
            }
        } else {
            $errorMessage = "";
        }
        return $errorMessage;
    }

    
    function booleanValue($value)
    {
        if (strcasecmp("false", $value) == 0 || strcasecmp("off", $value) == 0 || !$value) {
            return false;
        } else {
            return true;
        }
    }

    
    function fastImageCopyResampled (&$dst_image, $src_image, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h, $quality = 3)
    {
        if (empty($src_image) || empty($dst_image)) {
            return false;
        }

        if ($quality <= 1) {
            $temp = imagecreatetruecolor ($dst_w + 1, $dst_h + 1);
            imagecopyresized ($temp, $src_image, $dst_x, $dst_y, $src_x, $src_y, $dst_w + 1, $dst_h + 1, $src_w, $src_h);
            imagecopyresized ($dst_image, $temp, 0, 0, 0, 0, $dst_w, $dst_h, $dst_w, $dst_h);
            imagedestroy ($temp);

        } elseif ($quality < 5 && (($dst_w * $quality) < $src_w || ($dst_h * $quality) < $src_h)) {
            $tmp_w = $dst_w * $quality;
            $tmp_h = $dst_h * $quality;
            $temp = imagecreatetruecolor ($tmp_w + 1, $tmp_h + 1);
            imagecopyresized ($temp, $src_image, 0, 0, $src_x, $src_y, $tmp_w + 1, $tmp_h + 1, $src_w, $src_h);
            imagecopyresampled ($dst_image, $temp, $dst_x, $dst_y, 0, 0, $dst_w, $dst_h, $tmp_w, $tmp_h);
            imagedestroy ($temp);

        } else {
            imagecopyresampled ($dst_image, $src_image, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
        }

        return true;
    }

    
    function setMemoryForImage($imageWidth, $imageHeight, $imageBits, $imageChannels)
    {
        $MB = 1048576;          $K64 = 65536;            $TWEAKFACTOR = 2.4;          $memoryNeeded = round( ( $imageWidth * $imageHeight
        * $imageBits
        * $imageChannels / 8
        + $K64
        ) * $TWEAKFACTOR
        ) + 3*$MB;

                                $memoryLimit = CKFinder_Connector_Utils_Misc::returnBytes(@ini_get('memory_limit'))/$MB;
        if (!$memoryLimit) {
            $memoryLimit = 8;
        }

        $memoryLimitMB = $memoryLimit * $MB;
        if (function_exists('memory_get_usage')) {
            if (memory_get_usage() + $memoryNeeded > $memoryLimitMB) {
                $newLimit = $memoryLimit + ceil( ( memory_get_usage()
                + $memoryNeeded
                - $memoryLimitMB
                ) / $MB
                );
                if (@ini_set( 'memory_limit', $newLimit . 'M' ) === false) {
                    return false;
                }
            }
        } else {
            if ($memoryNeeded + 3*$MB > $memoryLimitMB) {
                $newLimit = $memoryLimit + ceil(( 3*$MB
                + $memoryNeeded
                - $memoryLimitMB
                ) / $MB
                );
                if (false === @ini_set( 'memory_limit', $newLimit . 'M' )) {
                    return false;
                }
            }
        }
        return true;
    }

    
    function returnBytes($val)
    {
        $val = trim($val);
        if (!$val) {
            return 0;
        }
        $last = strtolower($val[strlen($val)-1]);
        switch($last) {
                        case 'g':
                $val *= 1024;
            case 'm':
                $val *= 1024;
            case 'k':
                $val *= 1024;
        }

        return $val;
    }

    
    function inArrayCaseInsensitive($needle, $haystack)
    {
        if (!$haystack || !is_array($haystack)) {
            return false;
        }
        $lcase = array();
        foreach ($haystack as $key => $val) {
            $lcase[$key] = strtolower($val);
        }
        return in_array($needle, $lcase);
    }

    
    function mbBasename($file)
    {
        $explode = explode('/', str_replace("\\", "/", $file));
        return end($explode);
    }

    
    function imageCreateFromBmp($filename)
    {
                @set_time_limit(20);

        if (false === ($f1 = fopen($filename, "rb"))) {
            return false;
        }

        $FILE = unpack("vfile_type/Vfile_size/Vreserved/Vbitmap_offset", fread($f1, 14));
        if ($FILE['file_type'] != 19778) {
            return false;
        }

        $BMP = unpack('Vheader_size/Vwidth/Vheight/vplanes/vbits_per_pixel'.
        '/Vcompression/Vsize_bitmap/Vhoriz_resolution'.
        '/Vvert_resolution/Vcolors_used/Vcolors_important', fread($f1, 40));

        $BMP['colors'] = pow(2,$BMP['bits_per_pixel']);

        if ($BMP['size_bitmap'] == 0) {
            $BMP['size_bitmap'] = $FILE['file_size'] - $FILE['bitmap_offset'];
        }

        $BMP['bytes_per_pixel'] = $BMP['bits_per_pixel']/8;
        $BMP['bytes_per_pixel2'] = ceil($BMP['bytes_per_pixel']);
        $BMP['decal'] = ($BMP['width']*$BMP['bytes_per_pixel']/4);
        $BMP['decal'] -= floor($BMP['width']*$BMP['bytes_per_pixel']/4);
        $BMP['decal'] = 4-(4*$BMP['decal']);

        if ($BMP['decal'] == 4) {
            $BMP['decal'] = 0;
        }

        $PALETTE = array();
        if ($BMP['colors'] < 16777216) {
            $PALETTE = unpack('V'.$BMP['colors'], fread($f1, $BMP['colors']*4));
        }

                if ($BMP['size_bitmap'] > 3 * 2048 * 1536) {
            return false;
        }

        $IMG = fread($f1, $BMP['size_bitmap']);
        fclose($f1);
        $VIDE = chr(0);

        $res = imagecreatetruecolor($BMP['width'],$BMP['height']);
        $P = 0;
        $Y = $BMP['height']-1;

        $line_length = $BMP['bytes_per_pixel']*$BMP['width'];

        if ($BMP['bits_per_pixel'] == 24) {
            while ($Y >= 0)
            {
                $X=0;
                $temp = unpack( "C*", substr($IMG, $P, $line_length));

                while ($X < $BMP['width'])
                {
                    $offset = $X*3;
                    imagesetpixel($res, $X++, $Y, ($temp[$offset+3] << 16) + ($temp[$offset+2] << 8) + $temp[$offset+1]);
                }
                $Y--;
                $P += $line_length + $BMP['decal'];
            }
        }
        elseif ($BMP['bits_per_pixel'] == 8)
        {
            while ($Y >= 0)
            {
                $X=0;

                $temp = unpack( "C*", substr($IMG, $P, $line_length));

                while ($X < $BMP['width'])
                {
                    imagesetpixel($res, $X++, $Y, $PALETTE[$temp[$X] +1]);
                }
                $Y--;
                $P += $line_length + $BMP['decal'];
            }
        }
        elseif ($BMP['bits_per_pixel'] == 4)
        {
            while ($Y >= 0)
            {
                $X=0;
                $i = 1;
                $low = true;

                $temp = unpack( "C*", substr($IMG, $P, $line_length));

                while ($X < $BMP['width'])
                {
                    if ($low) {
                        $index = $temp[$i] >> 4;
                    }
                    else {
                        $index = $temp[$i++] & 0x0F;
                    }
                    $low = !$low;

                    imagesetpixel($res, $X++, $Y, $PALETTE[$index +1]);
                }
                $Y--;
                $P += $line_length + $BMP['decal'];
            }
        }
        elseif ($BMP['bits_per_pixel'] == 1)
        {
            $COLOR = unpack("n",$VIDE.substr($IMG,floor($P),1));
            if     (($P*8)%8 == 0) $COLOR[1] =  $COLOR[1]        >>7;
            elseif (($P*8)%8 == 1) $COLOR[1] = ($COLOR[1] & 0x40)>>6;
            elseif (($P*8)%8 == 2) $COLOR[1] = ($COLOR[1] & 0x20)>>5;
            elseif (($P*8)%8 == 3) $COLOR[1] = ($COLOR[1] & 0x10)>>4;
            elseif (($P*8)%8 == 4) $COLOR[1] = ($COLOR[1] & 0x8)>>3;
            elseif (($P*8)%8 == 5) $COLOR[1] = ($COLOR[1] & 0x4)>>2;
            elseif (($P*8)%8 == 6) $COLOR[1] = ($COLOR[1] & 0x2)>>1;
            elseif (($P*8)%8 == 7) $COLOR[1] = ($COLOR[1] & 0x1);
            $COLOR[1] = $PALETTE[$COLOR[1]+1];
        }
        else {
            return false;
        }

        return $res;
    }
}
