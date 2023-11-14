<?php
// Define o tipo de conteúdo como JSON
header('Content-Type: application/json');

// Configurações de conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cadastro_produtos";

// Cria uma nova instância de conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Inicializa um array para a resposta JSON
$response = array();

// Verifica se a conexão foi bem-sucedida
if ($conn->connect_error) {
    // Se a conexão falhar, gera uma resposta de erro em JSON e termina o script
    $response['error'] = true;
    $response['message'] = 'Conexão falhou: ' . $conn->connect_error;
    echo json_encode($response);
    die();
}

// Verifica se o ID do produto foi especificado na requisição
if (isset($_GET['id']) && !empty($_GET['id'])) {
    // Obtém o ID do produto da requisição
    $id = $_GET['id'];

    // SQL para excluir um registro com base no ID
    $sql = "DELETE FROM produtos WHERE id = $id";

    // Executa a consulta SQL de exclusão
    if ($conn->query($sql) === TRUE) {
        // Se a exclusão for bem-sucedida, gera uma mensagem de sucesso em JSON
        $response['message'] = 'Produto excluído com sucesso';
        echo json_encode($response);
    } else {
        // Se ocorrer um erro na exclusão, gera uma resposta de erro em JSON
        $response['error'] = true;
        $response['message'] = 'Erro ao excluir o produto: ' . $conn->error;
        echo json_encode($response);
    }
} else {
    // Se o ID do produto não foi especificado na requisição, gera uma resposta de erro em JSON
    $response['error'] = true;
    $response['message'] = 'ID do produto não especificado. A exclusão não foi realizada.';
    echo json_encode($response);
}

// Fecha a conexão com o banco de dados
$conn->close();
?>
