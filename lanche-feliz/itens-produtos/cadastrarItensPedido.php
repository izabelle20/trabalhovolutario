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

// Atualizar Item do Pedido
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'atualizar') {
    // Decodificar o corpo da solicitação JSON
    $data = json_decode(file_get_contents('php://input'), true);

    // Verificar se o ID do item do pedido está presente nos dados
    if (!isset($data['id_item_pedido'])) {
        echo json_encode(["status" => "error", "message" => "ID do item do pedido ausente"]);
        exit;
    }

    // Preparar a consulta SQL para atualizar o item do pedido
    $sql = "UPDATE item_do_pedido SET num_pedido = ?, codigo_produto = ?, quantidade = ?, valor_item = ? WHERE id_item_pedido = ?";

    try {
        // Usar declarações preparadas para evitar injeção de SQL
        $stmt = $mysqli->prepare($sql);

        if (!$stmt) {
            throw new Exception("Erro na preparação da consulta: " . $mysqli->error);
        }

        // Liga os parâmetros
        $stmt->bind_param(
            "sssd",
            $data['num_pedido'],
            $data['codigo_produto'],
            $data['quantidade'],
            $data['valor_item'],
            $data['id_item_pedido']
        );

        // Executa a consulta
        if (!$stmt->execute()) {
            throw new Exception("Erro ao executar a consulta: " . $stmt->error);
        }

        // Retornar uma resposta JSON com a mensagem de sucesso
        echo json_encode(["status" => "success", "message" => "Item do pedido atualizado com sucesso!"]);
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
}
?>
