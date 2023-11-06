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

    $sql = "SELECT * FROM matriculas WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $response = array(
            'id' => $row['id'],
            'nome_aluno' => $row['nome_aluno'],
            'id_aluno' => $row['id_aluno'],
            'idade_aluno' => $row['idade_aluno'],
            'serie' => $row['serie'],
            'curso' => $row['curso'],
            'campus' => $row['campus'],
            'periodo' => $row['periodo'],
            'nome_do_professor' => $row['nome_do_professor']
        );
        echo json_encode($response);
    } else {
        $response = array(
            'error' => true,
            'message' => 'Nenhuma matrícula encontrada com este ID.'
        );
        echo json_encode($response);
    }
} else {
    $response = array(
        'error' => true,
        'message' => 'ID da matrícula não especificado.'
    );
    echo json_encode($response);
}

$conn->close();
?>
