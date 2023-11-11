<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "matricula";

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Inicializar o array de resposta JSON
$response = array();

// Verificar conexão
if ($conn->connect_error) {
    $response['error'] = true;
    $response['message'] = 'Conexão falhou: ' . $conn->connect_error;
    echo json_encode($response);
    die();
}

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    // SQL para excluir um registro
    $sql = "DELETE FROM alunos WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        $response['message'] = 'Matrícula excluída com sucesso';
        echo json_encode($response);
    } else {
        $response['error'] = true;
        $response['message'] = 'Erro ao excluir a matrícula: ' . $conn->error;
        echo json_encode($response);
    }
} else {
    $response['error'] = true;
    $response['message'] = 'ID da matrícula não especificado. A exclusão não foi realizada.';
    echo json_encode($response);
}

$conn->close();
?>
