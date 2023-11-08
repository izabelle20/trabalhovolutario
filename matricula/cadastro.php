<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login_escola";

// Conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Verificar se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha']; // Lembre-se de criptografar a senha antes de armazenar no banco de dados

    // Inserir os dados no banco de dados
    $sql = "INSERT INTO usuarios (nome, email, senha) VALUES ('$nome', '$email', '$senha')";

    if ($conn->query($sql) === TRUE) {
        // Exibir uma mensagem de cadastro bem-sucedido em JavaScript
        echo "<script>alert('Cadastro realizado com sucesso!'); window.location.href = 'index.php';</script>";
        exit();
    } else {
        echo "Erro ao cadastrar: " . $conn->error;
    }
}

$conn->close();
?>