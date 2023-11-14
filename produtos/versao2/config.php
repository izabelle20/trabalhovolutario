<?php
// Define constantes para os parâmetros de conexão com o banco de dados
define('HOST', 'localhost'); // Host do banco de dados
define('USER', 'root');      // Nome de usuário do banco de dados
define('PASS', '');          // Senha do banco de dados
define('BASE', 'cadastro_produtos'); // Nome do banco de dados

// Cria uma nova instância da classe mysqli para estabelecer uma conexão com o banco de dados
$con = new mysqli(HOST, USER, PASS, BASE);

// Verifica se houve falha na conexão com o banco de dados
if ($con->connect_error) {
    // Encerra o script e exibe uma mensagem de erro se a conexão falhou
    die("Falha na conexão: " . $con->connect_error);
}

?>
