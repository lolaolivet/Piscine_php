<?php

if ($_POST['submit'] != 'OK' || ($_POST['login'] === '' || $_POST['oldpw'] === '' || $_POST['newpw'] === ''))
{
    echo "ERROR\n";
    return (10);
}
if (file_exists('../../private/passwd') === FALSE)
    echo "ERROR\n";

$res = unserialize(file_get_contents('../../private/passwd'));
$newpw = hash('sha512', $_POST['newpw']);
$oldpw = hash('sha512', $_POST['oldpw']);
$login = $_POST['login'];
$array[] = array("login" => $login, "passwd" => $newpw);
foreach ($res as $e => $value)
{
    if ($value['login'] === $login && $value['passwd'] == $oldpw)
    {
        print($value['passwd']."\n");
        print($oldpw."\n");
        $value['passwd'] = $newpw;
        $array[] = $e;
        file_put_contents('../../private/passwd', serialize($array));
        echo "OK\n";
        return (1);
    }
    else
    {
        echo "ERROR\n";
        return (1);
    }
}
?>