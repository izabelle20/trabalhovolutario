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

// Cadastra, atualiza, exclui ou salva um professor se a requisição for do tipo POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém os dados JSON da requisição e os converte para um array associativo
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['acao']) && $data['acao'] === 'salvar') { // Verifica se a ação é salvar
        // Lógica de salvar professor
        $id = $data['id'];
        $nome = $data['nome'];
        $disciplina = $data['diciplina']; // Corrigido o nome do campo
        $email = $data['email'];

        $check_stmt = $con->prepare("SELECT id FROM professores WHERE id = ?");
        $check_stmt->bind_param("i", $id);
        $check_stmt->execute();
        $check_stmt->store_result();

        if ($check_stmt->num_rows > 0) {
            // O professor existe, então atualiza os dados
            $stmt = $con->prepare("UPDATE professores SET nome=?, disciplina=?, email=? WHERE id=?");
            $stmt->bind_param("sssi", $nome, $disciplina, $email, $id);
        } else {
            // O professor não existe, então cria um novo
            $stmt = $con->prepare("INSERT INTO professores (nome, disciplina, email) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $nome, $disciplina, $email);
        }

        if ($stmt->execute()) {
            $response = array(
                'message' => 'Professor salvo com sucesso.'
            );
            echo json_encode($response);
        } else {
            $response = array(
                'error' => true,
                'message' => 'Erro ao salvar o professor: ' . $con->error
            );
            echo json_encode($response);
        }

        $stmt->close();
        $check_stmt->close();
    } else {
        // Se a ação não for reconhecida, retorna uma resposta JSON com uma mensagem de erro
        $response = array(
            'error' => true,
            'message' => 'Ação inválida. Forneça uma ação válida (salvar_professor).'
        );
        echo json_encode($response);
    }
}

$con->close(); // Fecha a conexão com o banco de dados
?>
