<?php
// Define o tipo de conteúdo como JSON
header('Content-Type: application/json');

// Configurações de conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cadastro_produtos";

// Cria uma nova instância de conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Inicializa um array para a resposta JSON
$response = array();

// Verifica se a conexão foi bem-sucedida
if ($conn->connect_error) {
    // Se a conexão falhar, gera uma resposta de erro em JSON e termina o script
    $response['error'] = true;
    $response['message'] = 'Conexão falhou: ' . $conn->connect_error;
    echo json_encode($response);
    die();
}

// Verifica se o ID do produto foi especificado na requisição
if (isset($_REQUEST["id"])) {
    // Obtém e escapa o ID do produto da requisição para evitar injeção de SQL
    $id = $conn->real_escape_string($_REQUEST["id"]);

    // Consulta para obter detalhes do produto pelo ID
    $sql = "SELECT * FROM produtos WHERE id='$id'";
    $res = $conn->query($sql);

    // Verifica se há resultados na consulta
    if ($res && $res->num_rows > 0) {
        // Se houver resultados, converte os dados do produto em um array associativo na resposta JSON
        $row = $res->fetch_assoc();
        $response['produto'] = array(
            'id' => $row['id'],
            'nome' => $row['nome'],
            'descricao' => $row['descricao'],
            'valor' => $row['valor'],
            'status' => $row['status']
        );
    } else {
        // Se nenhum produto for encontrado com o ID especificado, gera uma resposta de erro em JSON
        $response['error'] = true;
        $response['message'] = 'Produto não encontrado!';
    }
    // Fecha o resultado da consulta
    $res->close();
} else {
    // Se o ID do produto não foi especificado na requisição, gera uma resposta de erro em JSON
    $response['error'] = true;
    $response['message'] = 'ID do produto não especificado!';
}

// Converte a resposta em JSON e a imprime
echo json_encode($response);

// Fecha a conexão com o banco de dados
$conn->close();
?>
