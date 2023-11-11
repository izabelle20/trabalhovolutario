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

    if (isset($data['nome'], $data['id'], $data['idade'], $data['serie'], $data['curso'], $data['campus'], $data['periodo'], $data['nome_do_professor'])) {
        $nome = $data['nome'];
        $id = $data['id'];
        $idade = $data['idade'];
        $serie = $data['serie'];
        $curso = $data['curso'];
        $campus = $data['campus'];
        $periodo = $data['periodo'];
        $nome_do_professor = $data['nome_do_professor'];

        $sql = "INSERT INTO alunos (nome, id, idade, serie, curso, campus, periodo, nome_do_professor) VALUES ('$nome', '$id', '$idade', '$serie', '$curso', '$campus', '$periodo', '$nome_do_professor')";

        if ($con->query($sql) === TRUE) {
            $response['success'] = true;
            $response['message'] = 'Nova matrícula realizada com sucesso.';
        } else {
            $response['error'] = true;
            $response['message'] = 'Erro ao realizar matrícula: ' . $con->error;
        }

        $con->close();
    } else {
        $response['error'] = true;
        $response['message'] = 'Dados de matrícula ausentes. Por favor, forneça todos os campos necessários.';
    }
} else {
    $response['error'] = true;
    $response['message'] = 'Método de solicitação inválido. Apenas o método POST é permitido. Utilize o aplicativo (POSTMAN) para adicionar uma nova matrícula.';
}

echo json_encode($response);
?>
