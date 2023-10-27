<?php
header('Content-Type: application/json');

// Conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cadastro_produtos";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    $response = array(
        'error' => true,
        'message' => 'Conexão falhou: ' . $conn->connect_error
    );
    echo json_encode($response);
    die();
}

// Verificar se o ID do produto foi especificado
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    // Consulta para obter detalhes do produto pelo ID
    $sql = "SELECT * FROM produtos WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $response = array(
            'id' => $row['id'],
            'nome' => $row['nome'],
            'descricao' => $row['descricao'],
            'valor' => $row['valor'],
            'status' => $row['status']
        );
        echo json_encode($response);
    } else {
        $response = array(
            'error' => true,
            'message' => 'Nenhum produto encontrado com este ID.'
        );
        echo json_encode($response);
    }
} else {
    $response = array(
        'error' => true,
        'message' => 'ID do produto não especificado.'
    );
    echo json_encode($response);
}

$conn->close();
?>
