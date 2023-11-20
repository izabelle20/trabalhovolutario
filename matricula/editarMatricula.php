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

// Obter dados JSON da requisição
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['acao']) && $data['acao'] === 'editar') {
    // Verifique se todos os campos necessários estão presentes nos dados JSON
    if (isset($data['id'], $data['nome_aluno'], $data['idade'], $data['serie'], $data['curso'], $data['periodo'], $data['campus'], $data['nome_professor'], $data['matricula'])) {
        $id = $conn->real_escape_string($data['id']);
        $nome_aluno = $conn->real_escape_string($data['nome_aluno']);
        $idade = $conn->real_escape_string($data['idade']);
        $serie = $conn->real_escape_string($data['serie']);
        $curso = $conn->real_escape_string($data['curso']);
        $periodo = $conn->real_escape_string($data['periodo']);
        $campus = $conn->real_escape_string($data['campus']);
        $nome_professor =  $conn->real_escape_string($data['nome_professor']);
        $matricula = $conn->real_escape_string($data['matricula']);

        // Adicione isso antes da preparação da declaração SQL
        error_log("Nome do Professor antes da preparação SQL: " . $nome_professor);

        // Atualize o banco de dados conforme necessário
        $stmt = $conn->prepare("UPDATE alunos SET nome_aluno=?, idade=?, serie=?, curso=?, periodo=?, campus=?, nome_professor=?, matricula=? WHERE id=?");
        $stmt->bind_param("ssssssisi", $nome_aluno, $idade, $serie, $curso, $periodo, $campus, $nome_professor, $matricula, $id);

        // Após a execução da declaração SQL
        if ($stmt->execute()) {
            $response['message'] = 'Matrícula editada com sucesso.';
        } else {
            $response['error'] = true;
            $response['message'] = 'Erro ao editar a matrícula: ' . $conn->error;
            error_log("Erro ao executar a declaração SQL: " . $stmt->error);
        }

        $stmt->close();
    } else {
        $response['error'] = true;
        $response['message'] = 'Ação inválida ou dados insuficientes para editar a matrícula.';
    }
} else {
    $response['error'] = true;
    $response['message'] = 'Ação inválida ou dados insuficientes para editar a matrícula.';
}

echo json_encode($response);
$conn->close();
?>
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

// Obter dados JSON da requisição
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['acao']) && $data['acao'] === 'editar') {
    // Verifique se todos os campos necessários estão presentes nos dados JSON
    if (isset($data['id'], $data['nome_aluno'], $data['idade'], $data['serie'], $data['curso'], $data['periodo'], $data['campus'], $data['nome_professor'], $data['matricula'])) {
        $id = $conn->real_escape_string($data['id']);
        $nome_aluno = $conn->real_escape_string($data['nome_aluno']);
        $idade = $conn->real_escape_string($data['idade']);
        $serie = $conn->real_escape_string($data['serie']);
        $curso = $conn->real_escape_string($data['curso']);
        $periodo = $conn->real_escape_string($data['periodo']);
        $campus = $conn->real_escape_string($data['campus']);
        $nome_professor =  $conn->real_escape_string($data['nome_professor']);
        $matricula = $conn->real_escape_string($data['matricula']);

        // Adicione isso antes da preparação da declaração SQL
        error_log("Nome do Professor antes da preparação SQL: " . $nome_professor);

        // Atualize o banco de dados conforme necessário
        $stmt = $conn->prepare("UPDATE alunos SET nome_aluno=?, idade=?, serie=?, curso=?, periodo=?, campus=?, nome_professor=?, matricula=? WHERE id=?");
        $stmt->bind_param("ssssssisi", $nome_aluno, $idade, $serie, $curso, $periodo, $campus, $nome_professor, $matricula, $id);

        // Após a execução da declaração SQL
        if ($stmt->execute()) {
            $response['message'] = 'Matrícula editada com sucesso.';
        } else {
            $response['error'] = true;
            $response['message'] = 'Erro ao editar a matrícula: ' . $conn->error;
            error_log("Erro ao executar a declaração SQL: " . $stmt->error);
        }

        $stmt->close();
    } else {
        $response['error'] = true;
        $response['message'] = 'Ação inválida ou dados insuficientes para editar a matrícula.';
    }
} else {
    $response['error'] = true;
    $response['message'] = 'Ação inválida ou dados insuficientes para editar a matrícula.';
}

echo json_encode($response);
$conn->close();
?>
