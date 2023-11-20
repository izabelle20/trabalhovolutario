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

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Retrieve professor information
    if (isset($_REQUEST["id"])) {
        $id = $conn->real_escape_string($_REQUEST["id"]);
        $sql = "SELECT * FROM professores WHERE id='$id'";
        $res = $conn->query($sql);

        if ($res && $res->num_rows > 0) {
            $professors = array();

            while ($row = $res->fetch_assoc()) {
                $professor = array(
                    'id' => $row['id'],
                    'nome' => $row['nome'],
                    'disciplina' => $row['disciplina'],
                    'email' => $row['email']
                );
                $professors[] = $professor;
            }

            $response['professores'] = $professors;
        } else {
            $response['error'] = true;
            $response['message'] = 'Professor não encontrado!';
        }

        $res->close();
    } else {
        $response['error'] = true;
        $response['message'] = 'ID do professor não especificado!';
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Edit professor information
    $id = $conn->real_escape_string($_POST["id"]);
    $nome = $conn->real_escape_string($_POST["nome"]);
    $disciplina = $conn->real_escape_string($_POST["disciplina"]);
    $email = $conn->real_escape_string($_POST["email"]);

    $sql = "UPDATE professores SET nome='$nome', disciplina='$disciplina', email='$email' WHERE id='$id'";
    $result = $conn->query($sql);

    if ($result) {
        $response['message'] = 'Professor editado com sucesso!';
    } else {
        $response['error'] = true;
        $response['message'] = 'Erro ao editar o professor: ' . $conn->error;
    }
} else {
    $response['error'] = true;
    $response['message'] = 'Método de requisição inválido!';
}

echo json_encode($response);
$conn->close();
?>
