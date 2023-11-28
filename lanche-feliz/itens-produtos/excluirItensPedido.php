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

// Excluir Item do Pedido
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Obtém o número do pedido a ser excluído do parâmetro da URL
    $num_pedido = $_GET['num_pedido'] ?? null;

    if ($num_pedido !== null) {
        // Preparar a consulta SQL para excluir um item do pedido
        $sql = "DELETE FROM item_do_pedido WHERE num_pedido = ?";

        try {
            // Usar declarações preparadas para evitar injeção de SQL
            $stmt = $mysqli->prepare($sql);

            if (!$stmt) {
                throw new Exception("Erro na preparação da consulta: " . $mysqli->error);
            }

            // Liga os parâmetros
            $stmt->bind_param("i", $num_pedido);

            // Executa a consulta
            if (!$stmt->execute()) {
                throw new Exception("Erro ao executar a consulta: " . $stmt->error);
            }

            // Retorna uma resposta JSON com a mensagem de sucesso
            echo json_encode(["status" => "success", "message" => "Item do pedido excluído com sucesso"]);
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
        // Retorna uma resposta de erro JSON se o número do pedido estiver ausente
        echo json_encode(["status" => "error", "message" => "Número do pedido ausente na URL"]);
    }
}
?>
