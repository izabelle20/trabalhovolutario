<?php

// Exibir erros
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Verificar se o script está sendo executado
echo "O script está sendo executado.";

// Simula um banco de dados em memória
$clientes = [];

// Endpoint: /clientes (PUT) - Atualizar Cliente
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $requestData = json_decode(file_get_contents("php://input"), true);

    // Validação básica
    if (
        isset($requestData['codigo_cliente']) &&
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

        // Prepara a consulta SQL para atualizar um cliente
        $sql = "UPDATE cliente SET nome_cliente=?, endereco=?, cidade=?, CEP=?, UF=?, CPFCNPJ=?, tipo_cliente=? WHERE codigo_cliente=?";
        $stmt = $mysqli->prepare($sql);

        // Liga os parâmetros
        $stmt->bind_param(
            "sssssssi",
            $requestData['nome_cliente'],
            $requestData['endereco'],
            $requestData['cidade'],
            $requestData['CEP'],
            $requestData['UF'],
            $requestData['CPFCNPJ'],
            $requestData['tipo_cliente'],
            $requestData['codigo_cliente']
        );

        // Executa a consulta
        if ($stmt->execute()) {
            // Retorna uma resposta JSON de sucesso
            $response = ['status' => 'success', 'message' => 'Cliente atualizado com sucesso'];
            echo json_encode($response);
            http_response_code(200); // Código HTTP 200 - OK
        } else {
            // Retorna uma resposta de erro JSON se a consulta falhar
            $response = ['status' => 'error', 'message' => 'Erro ao atualizar cliente'];
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
} else {
    // Retorna uma resposta de erro JSON se a requisição for inválida
    $response = ['status' => 'error', 'message' => 'Requisição inválida'];
    echo json_encode($response);
    http_response_code(400); // Código HTTP 400 - Bad Request
}

?>
