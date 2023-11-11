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
    $sql = "DELETE FROM professores WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        $response['message'] = 'Professor excluído com sucesso';
        echo json_encode($response);
    } else {
        $response['error'] = true;
        $response['message'] = 'Erro ao excluir o professor: ' . $conn->error;
        echo json_encode($response);
    }
} else {
    $response['error'] = true;
    $response['message'] = 'ID do professor não especificado. A exclusão não foi realizada.';
    echo json_encode($response);
}

$conn->close();
?>
