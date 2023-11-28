<?php

// Simula um banco de dados em memória
$clientes = [];

// Endpoint: /clientes (POST) - Cadastrar Cliente
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $requestData = json_decode(file_get_contents("php://input"), true);

    // Validação básica
    if (
        isset($requestData['nome_cliente']) &&
        isset($requestData['endereco']) &&
        isset($requestData['cidade']) &&
        isset($requestData['CEP']) &&
        isset($requestData['UF']) &&
        isset($requestData['CPFCNPJ']) &&
        isset($requestData['tipo_cliente'])
    ) {
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

        // Prepara a consulta SQL para inserir um novo cliente
        $sql = "INSERT INTO cliente (nome_cliente, endereco, cidade, CEP, UF, CPFCNPJ, tipo_cliente) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $mysqli->prepare($sql);

        // Liga os parâmetros
        $stmt->bind_param(
            "sssssss",
            $requestData['nome_cliente'],
            $requestData['endereco'],
            $requestData['cidade'],
            $requestData['CEP'],
            $requestData['UF'],
            $requestData['CPFCNPJ'],
            $requestData['tipo_cliente']
        );

        // Executa a consulta
        if ($stmt->execute()) {
            // Retorna uma resposta JSON de sucesso
            $response = ['status' => 'success', 'message' => 'Cliente cadastrado com sucesso'];
            echo json_encode($response);
            http_response_code(201); // Código HTTP 201 - Created
        } else {
            // Retorna uma resposta de erro JSON se a consulta falhar
            $response = ['status' => 'error', 'message' => 'Erro ao cadastrar cliente'];
            echo json_encode($response);
            http_response_code(500); // Código HTTP 500 - Internal Server Error
        }

        // Fecha a declaração e a conexão
        $stmt->close();
        $mysqli->close();
    } else {
        // Retorna uma resposta de erro JSON se os dados estiverem ausentes
        $response = ['status' => 'error', 'message' => 'Dados do cliente incompletos'];
        echo json_encode($response);
        http_response_code(400); // Código HTTP 400 - Bad Request
    }
}

?>
