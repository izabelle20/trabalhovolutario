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

// Buscar Pedido
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Se necessário, você pode receber parâmetros da URL para filtrar a busca

    // Preparar a consulta SQL para buscar pedidos
    $sql = "SELECT * FROM pedido";

    try {
        // Executar a consulta
        $result = $mysqli->query($sql);

        if (!$result) {
            throw new Exception("Erro ao executar a consulta: " . $mysqli->error);
        }

        // Obter os resultados como um array associativo
        $pedidos = $result->fetch_all(MYSQLI_ASSOC);

        // Retornar uma resposta JSON com os pedidos encontrados
        echo json_encode(["status" => "success", "pedidos" => $pedidos]);
    } catch (Exception $e) {
        // Capturar exceções e retornar mensagem de erro
        echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    } finally {
        // Fechar a conexão
        $mysqli->close();
    }
}
?>
