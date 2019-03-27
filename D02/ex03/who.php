#!/usr/bin/php
<?php

$handle = fopen("/var/run/utmpx", "rb");
if ($handle) {
    while (($line = fgets($handle)) !== false) {
        $str .= $line;
    }
    $str = substr($str, 1256);
    while ($str) {
        $array[] = unpack("A256user/A4id/A32line_size/ipid/itype/Itime/L1timebis/a256host/I16other", $str);
        $str = substr($str, 628);
    }
    date_default_timezone_set('Europe/Paris');
    foreach ($array as $e)
    {
        if ($e[type] == 7)
            printf("%s %s  %s\n", $e["user"], $e["line_size"], strftime("%b %d %H:%M", $e["time"]));
    }
}
?>