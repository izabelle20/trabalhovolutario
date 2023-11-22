<?php
require_once('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id'])) {
        // Se o parâmetro 'id' estiver presente na requisição, busca um usuário pelo ID
        $id = $_GET['id'];
        $sql = "SELECT * FROM usuarios WHERE id=$id";
    } else {
        // Se não houver parâmetro 'id', busca todos os usuários
        $sql = "SELECT * FROM usuarios";
    }

    // Executa a consulta SQL
    $result = $conn->query($sql);

    // Verifica se há resultados na consulta
    if ($result->num_rows > 0) {
        $rows = array();
        // Converte os resultados em um array associativo
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        // Retorna os resultados no formato JSON
        echo json_encode($rows);
    } else {
        // Retorna uma mensagem se nenhum usuário for encontrado
        echo "Nenhum usuário encontrado";
    }
} else {
    // Retorna uma mensagem de erro se o método da requisição não for GET
    echo "Método não permitido";
}
