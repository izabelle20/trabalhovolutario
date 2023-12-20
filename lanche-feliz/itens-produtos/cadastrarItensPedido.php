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

// Cadastrar Item do Pedido
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Decodificar o corpo da solicitação JSON
    $data = json_decode(file_get_contents('php://input'), true);

    // Validação básica
    if (
        isset($data['num_pedido']) &&
        isset($data['codigo_produto']) &&
        isset($data['quantidade']) &&
        isset($data['valor_item'])
    ) {
        // Preparar a consulta SQL para cadastrar um novo item do pedido
        $sql = "INSERT INTO item_do_pedido (num_pedido, codigo_produto, quantidade, valor_item) VALUES (?, ?, ?, ?)";
        $stmt = $mysqli->prepare($sql);

        // Usar declarações preparadas para evitar injeção de SQL
        $stmt->bind_param(
            "sssd",
            $data['num_pedido'],
            $data['codigo_produto'],
            $data['quantidade'],
            $data['valor_item']
        );

        // Executar a consulta
        if ($stmt->execute()) {
            // Retornar uma resposta JSON de sucesso
            echo json_encode(['status' => 'success', 'message' => 'Item do pedido cadastrado com sucesso']);
            http_response_code(201); // Código HTTP 201 - Created
        } else {
            // Retornar uma resposta de erro JSON se a consulta falhar
            echo json_encode(['status' => 'error', 'message' => 'Erro ao cadastrar item do pedido']);
            http_response_code(500); // Código HTTP 500 - Internal Server Error
        }

        // Fechar a declaração
        $stmt->close();
    } else {
        // Retornar uma resposta de erro JSON se os dados estiverem ausentes
        echo json_encode(['status' => 'error', 'message' => 'Dados do item do pedido incompletos']);
        http_response_code(400); // Código HTTP 400 - Bad Request
    }
}

// Fechar a conexão
$mysqli->close();
?>
