<?php

$parameter = $_SERVER['QUERY_STRING'];
$array = explode("&", $parameter);
foreach ($array as $e)
{
    $e = preg_replace("/=/", ": ", $e);
    print($e."\n");
}

?>