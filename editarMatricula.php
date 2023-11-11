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
    $sql = "SELECT * FROM alunos WHERE id='$id'";
    $res = $conn->query($sql);

    if ($res) {
        if ($res->num_rows > 0) {
            $row = $res->fetch_assoc();
            $response['alunos'] = array(
                'id' => $row['id'],
                'nome' => $row['nome'],
                'idade' => $row['idade'],
                'serie' => $row['serie'],
                'curso' => $row['curso'],
                'campus' => $row['campus'],
                'periodo' => $row['periodo'],
                'nome_do_professor' => $row['nome_do_professor']
            );
        } else {
            $response['error'] = true;
            $response['message'] = 'Aluno não encontrado!';
        }
    } else {
        $response['error'] = true;
        $response['message'] = 'Erro na execução da consulta: ' . $conn->error;
    }

    $res->close();
} else {
    $response['error'] = true;
    $response['message'] = 'ID do aluno não especificado!';
}

echo json_encode($response);
$conn->close();
?>
