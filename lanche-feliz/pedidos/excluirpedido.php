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

// Excluir Pedido
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Decodificar o corpo da solicitação JSON
    $data = json_decode(file_get_contents('php://input'), true);

    // Verificar se o número do pedido foi fornecido
    if (isset($data['NUM_PEDIDO'])) {
        // Preparar a consulta SQL para excluir o pedido pelo número do pedido
        $sql = "DELETE FROM pedido WHERE NUM_PEDIDO = ?";

        try {
            // Usar declarações preparadas para evitar injeção de SQL
            $stmt = $mysqli->prepare($sql);

            if (!$stmt) {
                throw new Exception("Erro na preparação da consulta: " . $mysqli->error);
            }

            // Liga os parâmetros
            $stmt->bind_param("i", $data['NUM_PEDIDO']);

            // Executa a consulta
            if (!$stmt->execute()) {
                throw new Exception("Erro ao executar a consulta: " . $stmt->error);
            }

            // Retornar uma resposta JSON com a mensagem de sucesso
            echo json_encode(["status" => "success", "message" => "Pedido excluído com sucesso!"]);
        } catch (Exception $e) {
            // Capturar exceções e retornar mensagem de erro
            echo json_encode(["status" => "error", "message" => $e->getMessage()]);
        } finally {
            // Fechar a declaração e a conexão
            if ($stmt) {
                $stmt->close();
            }
            $mysqli->close();
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Número do pedido não fornecido"]);
    }
}
?>
