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

if (isset($_REQUEST["id"])) {
    $id = $conn->real_escape_string($_REQUEST["id"]);
    $sql = "SELECT * FROM professores WHERE id='$id'";
    $res = $conn->query($sql);

    if ($res && $res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $response['professores'] = array(
            'id' => $row['id'],
            'nome' => $row['nome'],
            'disciplina' => $row['disciplina'],
            'email' => $row['email']
        );
    } else {
        $response['error'] = true;
        $response['message'] = 'Professor não encontrado!';
    }
    $res->close();
} else {
    $response['error'] = true;
    $response['message'] = 'ID do professor não especificado!';
}

echo json_encode($response);
$conn->close();
?>
