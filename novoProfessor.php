<?php
header('Content-Type: application/json');

define('HOST', 'localhost');
define('USER', 'root');
define('PASS', '');
define('BASE', 'matricula');

$con = new mysqli(HOST, USER, PASS, BASE);

$response = array();

if ($con->connect_error) {
    $response['error'] = true;
    $response['message'] = 'Erro ao conectar ao banco de dados: ' . $con->connect_error;
    echo json_encode($response);
    die();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['nome'], $data['disciplina'], $data['email'])) {
        $nome = $data['nome'];
        $disciplina = $data['disciplina'];
        $email = $data['email'];

        $sql = "INSERT INTO professores (nome, disciplina, email) VALUES ('$nome', '$disciplina', '$email')";

        if ($con->query($sql) === TRUE) {
            $response['success'] = true;
            $response['message'] = 'Novo professor adicionado com sucesso.';
        } else {
            $response['error'] = true;
            $response['message'] = 'Erro ao adicionar novo professor: ' . $con->error;
        }

        $con->close();
    } else {
        $response['error'] = true;
        $response['message'] = 'Dados de professor ausentes. Por favor, forneça todos os campos necessários.';
    }
} else {
    $response['error'] = true;
    $response['message'] = 'Método de solicitação inválido. Apenas o método POST é permitido. Utilize o aplicativo (POSTMAN) para adicionar um novo professor.';
}

echo json_encode($response);
?>
