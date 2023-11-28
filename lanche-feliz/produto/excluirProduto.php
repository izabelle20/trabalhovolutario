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

// Excluir Produto
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Decodificar o corpo da solicitação JSON
    $data = json_decode(file_get_contents('php://input'), true);

    try {
        // Verificar se o CODIGO_PRODUTO está presente na solicitação
        if (!isset($data['CODIGO_PRODUTO'])) {
            throw new Exception("O campo CODIGO_PRODUTO é obrigatório para excluir um produto.");
        }

        // Preparar a consulta SQL para excluir o produto
        $sql = "DELETE FROM produto WHERE CODIGO_PRODUTO = ?";

        // Usar declarações preparadas para evitar injeção de SQL
        $stmt = $mysqli->prepare($sql);

        if (!$stmt) {
            throw new Exception("Erro na preparação da consulta: " . $mysqli->error);
        }

        // Liga os parâmetros
        $stmt->bind_param('i', $data['CODIGO_PRODUTO']);

        // Executa a consulta
        if (!$stmt->execute()) {
            throw new Exception("Erro ao executar a consulta: " . $stmt->error);
        }

        // Retornar uma resposta JSON com a mensagem de sucesso
        echo json_encode(["status" => "success", "message" => "Produto excluído com sucesso!"]);
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
