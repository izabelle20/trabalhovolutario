<?php
require_once('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtem os dados da requisição no formato JSON
    $data = json_decode(file_get_contents('php://input'), true);

    // Obtém os valores do array associativo
    $nome = $data['nome']; // Suponha que você tem um campo 'nome' na tabela
    $email = $data['email']; // Suponha que você tem um campo 'email' na tabela

    // Monta a consulta SQL para inserir um novo usuário
    $sql = "INSERT INTO usuarios (nome, email) VALUES ('$nome', '$email')";

    // Executa a consulta SQL
    if ($conn->query($sql) === TRUE) {
        // Retorna uma mensagem de sucesso se a inserção for bem-sucedida
        echo "Usuário cadastrado com sucesso!";
    } else {
        // Retorna uma mensagem de erro se houver algum problema na inserção
        echo "Erro ao cadastrar usuário: " . $conn->error;
    }
} else {
    // Retorna uma mensagem de erro se o método da requisição não for POST
    echo "Método não permitido";
}
