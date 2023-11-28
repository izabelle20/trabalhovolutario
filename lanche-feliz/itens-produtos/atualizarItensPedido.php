<?php

// Exibir erros
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Verificar se o script está sendo executado
echo "O script está sendo executado.";

// Simula um banco de dados em memória
$item_pedido = [];

// Endpoint: /pedido (PUT) - Atualizar pedido
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $requestData = json_decode(file_get_contents("php://input"), true);

    // Validação básica
    if (
        isset($requestData['num_pedido']) &&
        isset($requestData['codigo_produto']) &&
        isset($requestData['quantidade']) &&
        isset($requestData['valor_item'])
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

        // Prepara a consulta SQL para atualizar um item_do_pedido
        $sql = "UPDATE item_do_pedido SET codigo_produto=?, quantidade=?, valor_item=? WHERE num_pedido=?";
        $stmt = $mysqli->prepare($sql);

        // Liga os parâmetros
        $stmt->bind_param(
            "idii",
            $requestData['codigo_produto'],
            $requestData['quantidade'],
            $requestData['valor_item'],
            $requestData['num_pedido']
        );

        // Executa a consulta
        if ($stmt->execute()) {
            // Retorna uma resposta JSON de sucesso
            $response = ['status' => 'success', 'message' => 'Produto atualizado com sucesso'];
            echo json_encode($response);
            http_response_code(200); // Código HTTP 200 - OK
        } else {
            // Exibir mensagens de erro do MySQL
            echo json_encode(['status' => 'error', 'message' => 'Erro ao atualizar produto: ' . $stmt->error]);
            http_response_code(500); // Código HTTP 500 - Internal Server Error
        }

        // Fecha a declaração e a conexão
        $stmt->close();
        $mysqli->close();
    } else {
        // Retorna uma resposta de erro JSON se os dados estiverem ausentes
        $response = ['status' => 'error', 'message' => 'Dados do produto incompletos'];
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
