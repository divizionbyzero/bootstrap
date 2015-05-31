<?php

class AppHelper extends CComponent
{
    public static function trim_text($text, $words = 20)
    {
        $arr = explode(" ", $text);
        $arr = array_slice($arr, 0, $words);
        $new_str = implode(" ", $arr);

        return $new_str . '...';
    }

    public static function replaceSEO($s, $dot = 0)
    {
        $s = str_replace('&', 'and', strtolower(trim($s)));
        $ns = "";
        for ($i = 0; $i < strlen($s); $i++) {
            if (preg_match("([a-z0-9" . ($dot ? '\.' : '') . "])", $s[$i])) $ns .= $s[$i];
            else $ns .= "_";
        }
        while (strpos($ns, "--") !== false) {
            $ns = str_replace("--", "-", $ns);
        }
        if ($ns[0] == "-") $ns = substr($ns, 1);
        if ($ns[strlen($ns) - 1] == "-") $ns = substr($ns, 0, -1);

        return $ns;
    }

    public static function umd($num = 6, $slash = 1)
    {
        return substr(md5(uniqid(rand())), 1, $num) . ($slash ? "_" : "");
    }

    public static function clearFileName($FileName)
    {
        return strtolower(str_replace(' ', '_', $FileName));
    }

}