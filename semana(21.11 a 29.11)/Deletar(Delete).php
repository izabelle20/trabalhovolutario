<?php
require_once('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Obtem os dados da requisição no formato JSON
    $data = json_decode(file_get_contents('php://input'), true);

    // Obtém os valores do array associativo
    $id = $data['id']; // Suponha que você tem um campo 'id' na tabela

    // Monta a consulta SQL para deletar um usuário
    $sql = "DELETE FROM usuarios WHERE id=$id";

    // Executa a consulta SQL
    if ($conn->query($sql) === TRUE) {
        // Retorna uma mensagem de sucesso se a exclusão for bem-sucedida
        echo "Usuário deletado com sucesso!";
    } else {
        // Retorna uma mensagem de erro se houver algum problema na exclusão
        echo "Erro ao deletar usuário: " . $conn->error;
    }
} else {
    // Retorna uma mensagem de erro se o método da requisição não for DELETE
    echo "Método não permitido";
}
