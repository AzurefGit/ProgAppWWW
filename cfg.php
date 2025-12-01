<?php

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$db = 'moja_strona';

$link = mysqli_connect($dbhost, $dbuser, $dbpass, $db);
if (!$link)
    echo "<b>Przerwano połączenie z bazą danych!</b>";

$login = 'admin';
$pass = 'admin';
$admin_email = 'a@a32y4r3e23.com'
?>