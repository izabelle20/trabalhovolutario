<?php

// Exibir erros
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Verificar se o script está sendo executado
echo "O script está sendo executado.";

// Simula um banco de dados em memória
$clientes = [];

// Endpoint: /clientes (GET) - Buscar Todos os Clientes
if ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_GET['codigo_cliente'])) {
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

    // Prepara a consulta SQL para buscar todos os clientes
    $sql = "SELECT * FROM cliente";
    $result = $mysqli->query($sql);

    // Verifica se há resultados
    if ($result->num_rows > 0) {
        // Retorna os resultados como um array associativo
        $clientes = $result->fetch_all(MYSQLI_ASSOC);
        // Retorna uma resposta JSON com os clientes
        echo json_encode(['status' => 'success', 'data' => $clientes]);
        http_response_code(200); // Código HTTP 200 - OK
    } else {
        // Retorna uma resposta de erro JSON se não houver clientes
        echo json_encode(['status' => 'error', 'message' => 'Nenhum cliente encontrado']);
        http_response_code(404); // Código HTTP 404 - Not Found
    }

    // Fecha a conexão
    $mysqli->close();
}

// Endpoint: /clientes/{codigo_cliente} (GET) - Buscar Cliente por ID
elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['codigo_cliente'])) {
    $codigo_cliente = $_GET['codigo_cliente'];

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

    // Prepara a consulta SQL para buscar um cliente por ID
    $sql = "SELECT * FROM cliente WHERE codigo_cliente=?";
    $stmt = $mysqli->prepare($sql);

    // Liga os parâmetros
    $stmt->bind_param("i", $codigo_cliente);

    // Executa a consulta
    $stmt->execute();

    // Obtém os resultados
    $result = $stmt->get_result();

    // Verifica se há resultados
    if ($result->num_rows > 0) {
        // Retorna o resultado como um array associativo
        $cliente = $result->fetch_assoc();
        // Retorna uma resposta JSON com o cliente
        echo json_encode(['status' => 'success', 'data' => $cliente]);
        http_response_code(200); // Código HTTP 200 - OK
    } else {
        // Retorna uma resposta de erro JSON se o cliente não for encontrado
        echo json_encode(['status' => 'error', 'message' => 'Cliente não encontrado']);
        http_response_code(404); // Código HTTP 404 - Not Found
    }

    // Fecha a declaração e a conexão
    $stmt->close();
    $mysqli->close();
}

// Retorna uma resposta de erro JSON se a requisição for inválida
else {
    echo json_encode(['status' => 'error', 'message' => 'Requisição inválida']);
    http_response_code(400); // Código HTTP 400 - Bad Request
}

?>
