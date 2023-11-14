<?php
// Define o tipo de conteúdo como JSON
header('Content-Type: application/json');

// Conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cadastro_produtos";

// Cria uma nova instância de conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica se a conexão foi bem-sucedida
if ($conn->connect_error) {
    // Se a conexão falhou, gera uma resposta de erro em JSON e termina o script
    $response = array(
        'error' => true,
        'message' => 'Conexão falhou: ' . $conn->connect_error
    );
    echo json_encode($response);
    die();
}

// Verifica se o ID do produto foi especificado na requisição
if (isset($_GET['id']) && !empty($_GET['id'])) {
    // Obtém o ID do produto da requisição
    $id = $_GET['id'];

    // Consulta para obter detalhes do produto pelo ID
    $sql = "SELECT * FROM produtos WHERE id = $id";
    $result = $conn->query($sql);

    // Verifica se há resultados na consulta
    if ($result->num_rows > 0) {
        // Se houver resultados, converte os dados do produto em um array associativo
        $row = $result->fetch_assoc();
        $response = array(
            'id' => $row['id'],
            'nome' => $row['nome'],
            'descricao' => $row['descricao'],
            'valor' => $row['valor'],
            'status' => $row['status']
        );
        // Converte o array associativo em JSON e o imprime
        echo json_encode($response);
    } else {
        // Se nenhum produto for encontrado com o ID especificado, gera uma resposta de erro em JSON
        $response = array(
            'error' => true,
            'message' => 'Nenhum produto encontrado com este ID.'
        );
        echo json_encode($response);
    }
} else {
    // Se o ID do produto não foi especificado na requisição, gera uma resposta de erro em JSON
    $response = array(
        'error' => true,
        'message' => 'ID do produto não especificado.'
    );
    echo json_encode($response);
}

// Fecha a conexão com o banco de dados
$conn->close();
?>
