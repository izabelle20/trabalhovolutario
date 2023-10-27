<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cadastro_produtos";

$con = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($con->connect_error) {
    die("Conexão falhou: " . $con->connect_error);
}

// Cadastrar novo produto
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['acao']) && $_POST['acao'] === 'cadastrar') {
        $nome = $_POST['nome'];
        $descricao = $_POST['descricao'];
        $valor = $_POST['valor'];
        $status = $_POST['status'];

        $stmt = $con->prepare("INSERT INTO produtos (nome, descricao, valor, status) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssds", $nome, $descricao, $valor, $status);

        if ($stmt->execute()) {
            echo "Novo produto cadastrado com sucesso.";
        } else {
            echo "Erro ao cadastrar o produto: " . $con->error;
        }

        $stmt->close();
    } elseif (isset($_POST['acao']) && $_POST['acao'] === 'editar') { // Editar produto existente
        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $descricao = $_POST['descricao'];
        $valor = $_POST['valor'];
        $status = $_POST['status'];

        $stmt = $con->prepare("UPDATE produtos SET nome=?, descricao=?, valor=?, status=? WHERE id=?");
        $stmt->bind_param("ssdsi", $nome, $descricao, $valor, $status, $id);

        if ($stmt->execute()) {
            echo "Produto atualizado com sucesso.";
        } else {
            echo "Erro ao atualizar o produto: " . $con->error;
        }

        $stmt->close();
    } elseif (isset($_POST['acao']) && $_POST['acao'] === 'excluir') { // Excluir produto
        $id = $_POST['id'];

        $stmt = $con->prepare("DELETE FROM produtos WHERE id=?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo "Produto excluído com sucesso.";
        } else {
            echo "Erro ao excluir o produto: " . $con->error;
        }

        $stmt->close();
    }
}

$con->close();
?>
