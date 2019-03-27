#!/usr/bin/php
<?php

$str = [];
$res = [];
$i = 0;
$j = 0;
$str = preg_split("/[\t\s]/", $argv[1]);

foreach ($str as $e)
{
    if ($e)
    {
        $res[$i] = $e;
        $i++;
    }
}
while ($j < ($i - 1))
{
    print($res[$j]." ");
    $j++;
}
print($res[$j]."\n");

?>