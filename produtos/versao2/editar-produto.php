<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cadastro_produtos";

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
    $sql = "SELECT * FROM produtos WHERE id='$id'";
    $res = $conn->query($sql);

    if ($res && $res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $response['produto'] = array(
            'id' => $row['id'],
            'nome' => $row['nome'],
            'descricao' => $row['descricao'],
            'valor' => $row['valor'],
            'status' => $row['status']
        );
    } else {
        $response['error'] = true;
        $response['message'] = 'Produto não encontrado!';
    }
    $res->close();
} else {
    $response['error'] = true;
    $response['message'] = 'ID do produto não especificado!';
}

echo json_encode($response);
$conn->close();
?>
