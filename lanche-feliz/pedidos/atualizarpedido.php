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

// Atualizar Pedido
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Decodificar o corpo da solicitação JSON
    $data = json_decode(file_get_contents('php://input'), true);

    // Ajuste para tratar a ausência de data
    $data['data'] = isset($data['data']) ? $data['data'] : null;

    // Preparar a consulta SQL para atualizar um pedido existente
    $sql = "UPDATE pedido SET codigo_cliente = ?, codigo_vendedor = ?, data = ?, prazo_entrega = ?, valor_total = ?, forma_pgto = ?, pago = ? WHERE NUM_PEDIDO = ?";
    
    try {
        // Usar declarações preparadas para evitar injeção de SQL
        $stmt = $mysqli->prepare($sql);

        if (!$stmt) {
            throw new Exception("Erro na preparação da consulta: " . $mysqli->error);
        }

        // Liga os parâmetros
        $stmt->bind_param(
            "sssssssi",
            $data['codigo_cliente'],
            $data['codigo_vendedor'],
            $data['data'],
            $data['prazo_entrega'],
            $data['valor_total'],
            $data['forma_pgto'],
            $data['pago'],
            $data['NUM_PEDIDO']
        );

        // Executa a consulta
        if (!$stmt->execute()) {
            throw new Exception("Erro ao executar a consulta: " . $stmt->error);
        }

        // Retornar uma resposta JSON com a mensagem de sucesso
        echo json_encode(["status" => "success", "message" => "Pedido atualizado com sucesso!"]);
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
