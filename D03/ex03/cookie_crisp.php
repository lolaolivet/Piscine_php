<?php

if ($_GET['action'] == "set")
{
    if (!(setcookie($_GET['name'], $_GET['value'], time()+60)))
        return (1);
}
elseif ($_GET['action'] == 'get')
{
    if ($_COOKIE[$_GET['name']])
        echo $_COOKIE[$_GET['name']]."\n";
    else
        return (1);
}
elseif ($_GET['action'] == 'del')
{
    setcookie($_GET['name'], "", time()-3600);
}
?>