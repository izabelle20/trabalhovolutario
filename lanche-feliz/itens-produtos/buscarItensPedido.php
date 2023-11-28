<?php

// Exibir erros
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Verificar se o script está sendo executado
echo "O script está sendo executado.";

// Simula um banco de dados em memória
$item_pedido = [];

// Endpoint: /pedido (GET) - Buscar pedido pelo número
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
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

    // Verifica se o número do pedido está presente na URL
    if (isset($_GET['num_pedido'])) {
        $num_pedido = $_GET['num_pedido'];

        // Prepara a consulta SQL para buscar um item_do_pedido pelo número do pedido
        $sql = "SELECT * FROM item_do_pedido WHERE num_pedido = ?";
        $stmt = $mysqli->prepare($sql);

        // Liga os parâmetros
        $stmt->bind_param("i", $num_pedido);

        // Executa a consulta
        $stmt->execute();

        // Obtém o resultado da consulta
        $result = $stmt->get_result();

        // Verifica se há resultados
        if ($result->num_rows > 0) {
            // Obtém os dados do item do pedido
            $row = $result->fetch_assoc();

            // Retorna uma resposta JSON com os dados do item do pedido
            echo json_encode(["status" => "success", "data" => $row]);
            http_response_code(200); // Código HTTP 200 - OK
        } else {
            // Retorna uma resposta de erro JSON se o item do pedido não for encontrado
            echo json_encode(["status" => "error", "message" => "Item do pedido não encontrado"]);
            http_response_code(404); // Código HTTP 404 - Not Found
        }
    } else {
        // Retorna uma resposta de erro JSON se o número do pedido não estiver presente na URL
        echo json_encode(["status" => "error", "message" => "Número do pedido ausente na URL"]);
        http_response_code(400); // Código HTTP 400 - Bad Request
    }

    // Fecha a declaração e a conexão, se estiverem definidas
    if (isset($stmt)) {
        $stmt->close();
    }
    $mysqli->close();
} else {
    // Retorna uma resposta de erro JSON se a requisição for inválida
    $response = ['status' => 'error', 'message' => 'Requisição inválida'];
    echo json_encode($response);
    http_response_code(400); // Código HTTP 400 - Bad Request
}

?>
