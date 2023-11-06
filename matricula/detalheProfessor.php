<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "matricula";

$conn = new mysqli($servername, $username, $password, $dbname);

$response = array();

if ($conn->connect_error) {
    $response['error'] = true;
    $response['message'] = 'Conexão falhou: ' . $conn->connect_error;
    echo json_encode($response);
    die();
}

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM professores WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $response = array(
            'id' => $row['id'],
            'nome' => $row['nome'],
            'disciplina' => $row['disciplina'],
            'email' => $row['email']
        );
        echo json_encode($response);
    } else {
        $response = array(
            'error' => true,
            'message' => 'Nenhum professor encontrado com este ID.'
        );
        echo json_encode($response);
    }
} else {
    $response = array(
        'error' => true,
        'message' => 'ID do professor não especificado.'
    );
    echo json_encode($response);
}

$conn->close();
?>
