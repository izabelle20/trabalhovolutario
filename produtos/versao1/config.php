<?php
define('HOST', 'localhost');
define('USER', 'root');
define('PASS', '');
define('BASE', 'cadastro_produtos');

$con = new mysqli(HOST, USER, PASS, BASE);

if ($con->connect_error) {
    die("Falha na conexão: " . $con->connect_error);
}
?>