<?php
// Define o tipo de conteúdo como JSON para a resposta
header('Content-Type: application/json');

// Configurações para conexão com o banco de dados
define('HOST', 'localhost');
define('USER', 'root');
define('PASS', '');
define('BASE', 'semana21');

// Cria uma nova instância da classe mysqli para a conexão com o banco de dados
$con = new mysqli(HOST, USER, PASS, BASE);

// Inicializa um array para a resposta JSON
$response = array();

// Verifica se a conexão foi bem-sucedida
if ($con->connect_error) {
    // Se a conexão falhar, gera uma resposta de erro em JSON e termina o script
    $response['error'] = true;
    $response['message'] = 'Conexão falhou: ' . $con->connect_error;
    echo json_encode($response);
    die();
}

// Verifica se o ID do produto foi especificado na requisição
if (isset($_GET['id']) && !empty($_GET['id'])) {
    // Obtém o ID do produto da requisição
    $id = $_GET['id'];

    // SQL para excluir um registro com base no ID
    $sql = "DELETE FROM usuarios WHERE id = $id";

    // Executa a consulta SQL de exclusão
    if ($con->query($sql) === TRUE) {
        // Se a exclusão for bem-sucedida, gera uma mensagem de sucesso em JSON
        $response['message'] = 'Usuário excluído com sucesso';
        echo json_encode($response);
    } else {
        // Se ocorrer um erro na exclusão, gera uma resposta de erro em JSON
        $response['error'] = true;
        $response['message'] = 'Erro ao excluir o usuário: ' . $con->error;
        echo json_encode($response);
    }
} else {
    // Se o ID do produto não foi especificado na requisição, gera uma resposta de erro em JSON
    $response['error'] = true;
    $response['message'] = 'ID do usuário não especificado. A exclusão não foi realizada.';
    echo json_encode($response);
}

// Fecha a conexão com o banco de dados
$con->close();
?>
