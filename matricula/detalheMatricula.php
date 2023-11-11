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

    $sql = "SELECT * FROM alunos WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $response = array(
            'id' => $row['id'],
            'nome' => isset($row['nome']) ? $row['nome'] : null,
            'idade' => isset($row['idade']) ? $row['idade'] : null,
            'serie' => isset($row['serie']) ? $row['serie'] : null,
            'curso' => isset($row['curso']) ? $row['curso'] : null,
            'campus' => isset($row['campus']) ? $row['campus'] : null,
            'periodo' => isset($row['periodo']) ? $row['periodo'] : null,
            'nome_do_professor' => isset($row['nome_do_professor']) ? $row['nome_do_professor'] : null
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
