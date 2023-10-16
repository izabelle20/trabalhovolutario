<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cadastro_produtos";

$con = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($con->connect_error) {
    die("Conexão falhou: " . $con->connect_error);
}

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
    }
}
$con->close();
?>
