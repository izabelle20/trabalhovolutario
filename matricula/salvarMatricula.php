<?php
// Define o tipo de conteúdo como JSON
header('Content-Type: application/json');

// Configuração do banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "matricula";

// Cria uma nova conexão com o banco de dados
$con = new mysqli($servername, $username, $password, $dbname);

// Verifica se a conexão foi bem-sucedida
if ($con->connect_error) {
    // Se houver erro na conexão, retorna uma resposta JSON com a mensagem de erro
    $response = array(
        'error' => true,
        'message' => 'Conexão falhou: ' . $con->connect_error
    );
    echo json_encode($response);
    die(); // Encerra o script
}

// Cadastra, atualiza, exclui ou salva um aluno se a requisição for do tipo POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém os dados JSON da requisição e os converte para um array associativo
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['acao']) && $data['acao'] === 'salvar') { // Salvar (criar ou atualizar) aluno
        // Lógica de salvar aluno
        $id = $data['id'];
        $nome_aluno = $data['nome_aluno'];
        $serie = $data['serie'];
        $idade = $data['idade'];
        $curso = $data['curso'];
        $periodo = $data['periodo'];
        $campus = $data['campus'];
        $nome_professor = $data['nome_professor'];
        $matricula = $data['matricula'];

        // Use prepared statement para evitar SQL injection
        $check_stmt = $con->prepare("SELECT id FROM matricula.alunos WHERE matricula = ?");
        $check_stmt->bind_param("s", $matricula);
        $check_stmt->execute();
        $check_stmt->store_result();

        if ($check_stmt->num_rows > 0) {
            // O aluno existe, então atualiza os dados
            $stmt = $con->prepare("UPDATE matricula.alunos SET nome_aluno=?, serie=?, idade=?, curso=?, periodo=?, campus=?, nome_professor=?, matricula=? WHERE id=?");
            $stmt->bind_param("ssdssssi", $nome_aluno, $serie, $idade, $curso, $periodo, $campus, $nome_professor, $matricula, $id);
        } else {
            // O aluno não existe, então cria um novo
            $stmt = $con->prepare("INSERT INTO matricula.alunos (nome_aluno, serie, idade, curso, periodo, campus, nome_professor, matricula) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssdssssi", $nome_aluno, $serie, $idade, $curso, $periodo, $campus, $nome_professor, $matricula);
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
        // Se a ação não for reconhecida, retorna uma resposta JSON com uma mensagem de erro
        $response = array(
            'error' => true,
            'message' => 'Ação inválida. Forneça uma ação válida (salvar).'
        );
        echo json_encode($response);
    }
}

$con->close(); // Fecha a conexão com o banco de dados
?>
