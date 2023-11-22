<?php
require_once('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Obtem os dados da requisição no formato JSON
    $data = json_decode(file_get_contents('php://input'), true);

    // Obtém os valores do array associativo
    $id = $data['id']; // Suponha que você tem um campo 'id' na tabela
    $nome = $data['nome']; // Suponha que você tem um campo 'nome' na tabela
    $email = $data['email']; // Suponha que você tem um campo 'email' na tabela

    // Monta a consulta SQL para atualizar um usuário
    $sql = "UPDATE usuarios SET nome='$nome', email='$email' WHERE id=$id";

    // Executa a consulta SQL
    if ($conn->query($sql) === TRUE) {
        // Retorna uma mensagem de sucesso se a atualização for bem-sucedida
        echo "Usuário atualizado com sucesso!";
    } else {
        // Retorna uma mensagem de erro se houver algum problema na atualização
        echo "Erro ao atualizar usuário: " . $conn->error;
    }
} else {
    // Retorna uma mensagem de erro se o método da requisição não for PUT
    echo "Método não permitido";
}
