#!/usr/bin/php
<?php
function replace_quotes($match)
{
    $str = strtoupper($match[0]);
    return ($str);
}

function replace_balise($match)
{
    $match[0] = preg_replace_callback("/>(.*?)</s", 'replace_quotes', $match[0]);
    return ($match[0]);
}

$txt = file_get_contents("$argv[1]");
$txt = preg_replace_callback('/\".*?\"/', 'replace_quotes', $txt);
$txt = preg_replace_callback("/<a(.*?)<\/a>/s", 'replace_balise', $txt);
print($txt);
?>