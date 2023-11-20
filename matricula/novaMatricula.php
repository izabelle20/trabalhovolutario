<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "matricula";

$con = new mysqli($servername, $username, $password, $dbname);

if ($con->connect_error) {
    $response = array(
        'error' => true,
        'message' => 'Conexão falhou: ' . $con->connect_error
    );
    echo json_encode($response);
    die();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['acao'])) {
        if ($data['acao'] === 'salvar') {
            if (!isset($data['nome_aluno'], $data['serie'], $data['idade'], $data['curso'], $data['periodo'], $data['campus'], $data['nome_professor'], $data['matricula'], $data['id'])) {
                $response = array(
                    'error' => true,
                    'message' => 'Dados incompletos fornecidos.'
                );
                echo json_encode($response);
                die();
            }

            $id = $data['id'];
            $nome_aluno = $data['nome_aluno'];
            $serie = $data['serie'];
            $idade = $data['idade'];
            $curso = $data['curso'];
            $periodo = $data['periodo'];
            $campus = $data['campus'];
            $nome_professor = $data['nome_professor'];
            $matricula = $data['matricula'];

            $check_stmt = $con->prepare("SELECT id FROM matricula.alunos WHERE matricula = ?");
            $check_stmt->bind_param("s", $matricula);
            $check_stmt->execute();
            $check_stmt->store_result();

            if ($check_stmt->num_rows > 0) {
                $stmt = $con->prepare("INSERT INTO matricula.alunos (nome_aluno, serie, idade, curso, periodo, campus, nome_professor, matricula) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssdssiss", $nome_aluno, $serie, $idade, $curso, $periodo, $campus, $nome_professor, $matricula);
            } else {
                $stmt = $con->prepare("INSERT INTO matricula.alunos (nome_aluno, serie, idade, curso, periodo, campus, nome_professor, matricula) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssdsssssi", $nome_aluno, $serie, $idade, $curso, $periodo, $campus, $nome_professor, $matricula);
            }

            if ($stmt->execute()) {
                $response = array(
                    'message' => 'Aluno salvo com sucesso.'
                );
                echo json_encode($response);
            } else {
                $response = array(
                    'error' => true,
                    'message' => 'Erro ao salvar o aluno: ' . $stmt->error
                );
                echo json_encode($response);
            }

            $stmt->close();
            $check_stmt->close();
        } else {
            $response = array(
                'error' => true,
                'message' => 'Ação inválida. Forneça uma ação válida (salvar).'
            );
            echo json_encode($response);
        }
    }
}

$con->close();
?>
