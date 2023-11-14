<?php
// Define o tipo de conteúdo como JSON
header('Content-Type: application/json');

// Configuração do banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cadastro_produtos";

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

// Cadastra, atualiza, exclui ou salva um produto se a requisição for do tipo POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém os dados JSON da requisição e os converte para um array associativo
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['acao'])) {
        if ($data['acao'] === 'cadastrar') { // Cadastrar novo produto
            // Lógica de cadastro de produto
            $nome = $data['nome'];
            $descricao = $data['descricao'];
            $valor = $data['valor'];
            $status = $data['status'];

            $stmt = $con->prepare("INSERT INTO produtos (nome, descricao, valor, status) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssds", $nome, $descricao, $valor, $status);

            if ($stmt->execute()) {
                $response = array(
                    'message' => 'Novo produto cadastrado com sucesso.'
                );
                echo json_encode($response);
            } else {
                $response = array(
                    'error' => true,
                    'message' => 'Erro ao cadastrar o produto: ' . $con->error
                );
                echo json_encode($response);
            }

            $stmt->close();
        } elseif ($data['acao'] === 'editar') { // Editar produto existente
            // Lógica de edição de produto
            $id = $data['id'];
            $nome = $data['nome'];
            $descricao = $data['descricao'];
            $valor = $data['valor'];
            $status = $data['status'];

            $stmt = $con->prepare("UPDATE produtos SET nome=?, descricao=?, valor=?, status=? WHERE id=?");
            $stmt->bind_param("ssdsi", $nome, $descricao, $valor, $status, $id);

            if ($stmt->execute()) {
                $response = array(
                    'message' => 'Produto atualizado com sucesso.'
                );
                echo json_encode($response);
            } else {
                $response = array(
                    'error' => true,
                    'message' => 'Erro ao atualizar o produto: ' . $con->error
                );
                echo json_encode($response);
            }

            $stmt->close();
        } elseif ($data['acao'] === 'excluir') { // Excluir produto
            // Lógica de exclusão de produto
            $id = $data['id'];

            $stmt = $con->prepare("DELETE FROM produtos WHERE id=?");
            $stmt->bind_param("i", $id);

            if ($stmt->execute()) {
                $response = array(
                    'message' => 'Produto excluído com sucesso.'
                );
                echo json_encode($response);
            } else {
                $response = array(
                    'error' => true,
                    'message' => 'Erro ao excluir o produto: ' . $con->error
                );
                echo json_encode($response);
            }

            $stmt->close();
        } elseif ($data['acao'] === 'salvar') { // Salvar (criar ou atualizar) produto
            // Lógica de salvar produto
            $id = $data['id'];
            $nome = $data['nome'];
            $descricao = $data['descricao'];
            $valor = $data['valor'];
            $status = $data['status'];

            $check_stmt = $con->prepare("SELECT id FROM produtos WHERE id = ?");
            $check_stmt->bind_param("i", $id);
            $check_stmt->execute();
            $check_stmt->store_result();

            if ($check_stmt->num_rows > 0) {
                // O produto existe, então atualiza os dados
                $stmt = $con->prepare("UPDATE produtos SET nome=?, descricao=?, valor=?, status=? WHERE id=?");
                $stmt->bind_param("ssdsi", $nome, $descricao, $valor, $status, $id);
            } else {
                // O produto não existe, então cria um novo
                $stmt = $con->prepare("INSERT INTO produtos (nome, descricao, valor, status) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssds", $nome, $descricao, $valor, $status);
            }

            if ($stmt->execute()) {
                $response = array(
                    'message' => 'Produto salvo com sucesso.'
                );
                echo json_encode($response);
            } else {
                $response = array(
                    'error' => true,
                    'message' => 'Erro ao salvar o produto: ' . $con->error
                );
                echo json_encode($response);
            }

            $stmt->close();
            $check_stmt->close();
        } else {
            // Se a ação não for reconhecida, retorna uma resposta JSON com uma mensagem de erro
            $response = array(
                'error' => true,
                'message' => 'Ação inválida. Forneça uma ação válida (cadastrar, editar, salvar ou excluir).'
            );
            echo json_encode($response);
        }
    }
}

$con->close(); // Fecha a conexão com o banco de dados
?>
