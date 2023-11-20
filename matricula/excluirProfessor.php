<?php
// Configuração do cabeçalho para indicar que a resposta é em formato JSON
header('Content-Type: application/json');

// Configuração das informações de conexão ao banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "matricula";

// Criar uma conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Inicializar o array de resposta JSON
$response = array();

// Verificar se a conexão foi bem-sucedida
if ($conn->connect_error) {
    // Se a conexão falhar, configurar dados de erro e encerrar o script
    $response['error'] = true;
    $response['message'] = 'Conexão falhou: ' . $conn->connect_error;
    echo json_encode($response);
    die();
}

// Verificar se o parâmetro "id" está presente na URL e não está vazio
if (isset($_GET['id']) && !empty($_GET['id'])) {
    // Obter o valor do parâmetro "id"
    $id = $_GET['id'];

    // SQL para excluir um registro na tabela "professores" com base no ID fornecido
    $sql = "DELETE FROM professores WHERE id = $id";

    // Executar a consulta SQL e verificar se foi bem-sucedida
    if ($conn->query($sql) === TRUE) {
        // Se a exclusão foi bem-sucedida, configurar uma mensagem de sucesso
        $response['message'] = 'Professor excluído com sucesso';
        echo json_encode($response);
    } else {
        // Se houver um erro durante a exclusão, configurar dados de erro
        $response['error'] = true;
        $response['message'] = 'Erro ao excluir o professor: ' . $conn->error;
        echo json_encode($response);
    }
} else {
    // Se o parâmetro "id" não estiver presente ou estiver vazio, configurar dados de erro
    $response['error'] = true;
    $response['message'] = 'ID do professor não especificado. A exclusão não foi realizada.';
    echo json_encode($response);
}

// Fechar a conexão com o banco de dados
$conn->close();
?>
