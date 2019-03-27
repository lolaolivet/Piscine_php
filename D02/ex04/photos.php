#!/usr/bin/php
<?php

function create_file($name, $folder, $curl)
{
    preg_match("/^https?:\/\/\K[^\/]*/", $folder, $f);
    if (is_dir($f[0]) === FALSE && mkdir($f[0], 0755) === FALSE)
    {
        echo "Can't create dir\n";
        return (1);
    }
    $my_file = fopen("$f[0]/$name", "w") or die;
    $c = curl_init($curl);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, TRUE);
    $res = curl_exec($c);
    fwrite($my_file, $res);
    fclose($my_file);
}

if ($argc == 2)
{
    $c = curl_init($argv[1]);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, TRUE);
    $res = curl_exec($c);
    if (preg_match_all('/(?<=\<img src=\")(.*?)(?=\")/', "$res", $img)) {
        foreach ($img[0] as $e)
        {
            if(preg_match("/^(http)/", $e))
            {
                preg_match("/(?<=\/)[^\/]*$/", $e, $name);
                create_file($name[0], $argv[1], $e);
            }
            else
            {
                preg_match("/(?<=\/)[^\/]*$/", $e, $name);
                create_file($name[0], $argv[1], $argv[1].$e);
            }
        }
    }
    curl_close($c);
}
?>