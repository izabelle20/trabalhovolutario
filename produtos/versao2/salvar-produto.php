<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cadastro_produtos";

$con = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($con->connect_error) {
    $response = array(
        'error' => true,
        'message' => 'Conexão falhou: ' . $con->connect_error
    );
    echo json_encode($response);
    die();
}

// Cadastrar novo produto
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['acao']) && $data['acao'] === 'cadastrar') {
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
    } elseif (isset($data['acao']) && $data['acao'] === 'editar') { // Editar produto existente
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
    } elseif (isset($data['acao']) && $data['acao'] === 'excluir') { // Excluir produto
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
    } else {
        $response = array(
            'error' => true,
            'message' => 'Ação inválida. Forneça uma ação válida (cadastrar, editar ou excluir).'
        );
        echo json_encode($response);
    }
}

$con->close();
?>
