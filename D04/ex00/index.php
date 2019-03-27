<?php

session_start();

if ($_GET['submit'] == 'OK' && $_GET['login'] != '' && $_GET['passwd'] != '')
{
    $_SESSION['login'] = $_GET['login'];
    $_SESSION['passwd'] = $_GET['passwd'];
    $_SESSION['id'] = $_COOKIE['PHPSESSID'];
}

echo "<html><body>
<form method='get' action='index.php'>
    Identifiant: <input type='text' name='login' value='".$_SESSION['login']."' required />
    <br/>
    Mot de passe: <input type='password' name='passwd' value='".$_SESSION['passwd']."' required />
    <input type='submit' name='submit' value='OK' />
</form>
</body></html>";
echo "\n";
?>