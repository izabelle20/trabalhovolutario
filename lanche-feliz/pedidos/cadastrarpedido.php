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

// Cadastrar Pedido
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Decodificar o corpo da solicitação JSON
    $data = json_decode(file_get_contents('php://input'), true);

    // Ajuste para tratar a ausência de data
    $data['data'] = isset($data['data']) ? $data['data'] : null;

    // Preparar a consulta SQL para inserir um novo pedido
    $sql = "INSERT INTO pedido (NUM_PEDIDO, codigo_cliente, codigo_vendedor, data, prazo_entrega, valor_total, forma_pgto, pago) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    
    try {
        // Usar declarações preparadas para evitar injeção de SQL
        $stmt = $mysqli->prepare($sql);

        if (!$stmt) {
            throw new Exception("Erro na preparação da consulta: " . $mysqli->error);
        }

        // Liga os parâmetros
        $stmt->bind_param(
            "sssssssi",
            $data['NUM_PEDIDO'],
            $data['codigo_cliente'],
            $data['codigo_vendedor'],
            $data['data'],
            $data['prazo_entrega'],
            $data['valor_total'],
            $data['forma_pgto'],
            $data['pago']
        );

        // Executa a consulta
        if (!$stmt->execute()) {
            throw new Exception("Erro ao executar a consulta: " . $stmt->error);
        }

        // Obter o ID do pedido recém-criado
        $id = $mysqli->insert_id;

        // Retornar uma resposta JSON com a mensagem e o ID do pedido
        echo json_encode(["status" => "success", "message" => "Pedido cadastrado com sucesso!", "id" => $id]);
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
