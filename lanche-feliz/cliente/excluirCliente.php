<?php

// Exibir erros
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Verificar se o script está sendo executado
echo "O script está sendo executado.";

// Simula um banco de dados em memória
$clientes = [];

// Endpoint: /clientes (DELETE) - Excluir Cliente
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Obtém o nome do cliente da URL
    $nome_cliente = isset($_GET['nome_cliente']) ? $_GET['nome_cliente'] : null;

    // Validação básica do nome do cliente
    if ($nome_cliente !== null) {
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

        // Verifica se o cliente existe antes de excluir
        $check_sql = "SELECT * FROM cliente WHERE nome_cliente = ?";
        $check_stmt = $mysqli->prepare($check_sql);
        $check_stmt->bind_param("s", $nome_cliente);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result->num_rows > 0) {
            // O cliente existe, proceda com a exclusão
            $delete_sql = "DELETE FROM cliente WHERE nome_cliente = ?";
            $delete_stmt = $mysqli->prepare($delete_sql);
            $delete_stmt->bind_param("s", $nome_cliente);

            if ($delete_stmt->execute()) {
                // Retorna uma resposta JSON de sucesso
                $response = ['status' => 'success', 'message' => 'Cliente excluído com sucesso'];
                echo json_encode($response);
                http_response_code(200); // Código HTTP 200 - OK
            } else {
                // Retorna uma resposta de erro JSON se a exclusão falhar
                $response = ['status' => 'error', 'message' => 'Erro ao excluir cliente'];
                echo json_encode($response);
                http_response_code(500); // Código HTTP 500 - Internal Server Error
            }

            $delete_stmt->close();
        } else {
            // Retorna uma resposta de erro JSON se o cliente não for encontrado
            $response = ['status' => 'error', 'message' => 'Cliente não encontrado'];
            echo json_encode($response);
            http_response_code(404); // Código HTTP 404 - Not Found
        }

        // Fecha a conexão
        $check_stmt->close();
        $mysqli->close();
    } else {
        // Retorna uma resposta de erro JSON se o nome do cliente não estiver presente
        $response = ['status' => 'error', 'message' => 'Nome do cliente não fornecido'];
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
