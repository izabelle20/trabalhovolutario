<?php
define('HOST', 'localhost');
define('USER', 'root');
define('PASS', '');
define('BASE', 'matricula');

$con = new mysqli(HOST, USER, PASS, BASE);

if ($con->connect_error) {
    die("Falha na conexão: " . $con->connect_error);
}
?>