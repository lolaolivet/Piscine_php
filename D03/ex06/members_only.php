<?php

if ($_SERVER['PHP_AUTH_USER'] == '')
{
    header("WWW-Authenticate: Basic");
}
if($_SERVER['PHP_AUTH_USER'] == 'zaz' && $_SERVER['PHP_AUTH_PW'] == 'jaimelespetitsponeys')
{
    $data = base64_encode(file_get_contents("../../img/42.png"));
    echo "<html><body>
Bonjour Zaz<br />
<img src='data:image/png;base64,".$data."'>
</body></html>\n";
}
else {
    header("HTTP/1.1 401 Unauthorized");
    header("WWW-Authenticate: Basic realm=''Espace membres''");
    echo "<html><body>Cette zone est accessible uniquement aux membres du site</body></html>\n";
    header("Connection: close");
}
?>