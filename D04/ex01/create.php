<?php
session_start();

if ($_POST['submit'] != 'OK' || ($_POST['submit'] == 'OK' && ($_POST['login'] == '' || $_POST['passwd'] == '')))
{
    echo "ERROR\n";
    return (1);
}
if (file_exists('../../private') === FALSE)
    mkdir('../../private', 0755);
if (file_exists('../../private/passwd') === FALSE)
    file_put_contents('../../private/passwd','');

$res = unserialize(file_get_contents('../../private/passwd'));
$passwd = hash('sha512', $_POST['passwd']);
$login = $_POST['login'];
$array[] = array("login" => $login, "passwd" => $passwd);
foreach ($res as $e => $value)
{
    if ($value['login'] === $_POST['login'])
    {
        echo "ERROR\n";
        return (1);
    }
    $array[] = $e;
}
file_put_contents('../../private/passwd', serialize($array));
echo "OK\n";
?>