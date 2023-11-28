<?php

// Substitua as configurações do banco de dados pelos valores corretos
$hostname = "localhost";
$username = "root";
$password = "";
$database = "quitanda";

// Conecta ao banco de dados
$mysqli = new mysqli($hostname, $username, $password, $database);

// Verifica a conexão
if ($mysqli->connect_error) {
    die("Conexão falhou: " . $mysqli->connect_error);
}

// Buscar Produtos
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Preparar a consulta SQL para buscar produtos
    $sql = "SELECT * FROM produto";

    // Executar a consulta
    $result = $mysqli->query($sql);

    // Verificar se a consulta foi bem-sucedida
    if ($result) {
        // Converter o resultado em um array associativo
        $produtos = $result->fetch_all(MYSQLI_ASSOC);

        // Retornar uma resposta JSON com os produtos
        echo json_encode(["status" => "success", "produtos" => $produtos]);
    } else {
        // Retornar uma resposta de erro JSON se a consulta falhar
        echo json_encode(["status" => "error", "message" => "Erro ao buscar produtos"]);
    }

    // Fechar a conexão
    $mysqli->close();
}

?>
