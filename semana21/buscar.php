<?php
// Define o tipo de conteúdo como JSON para a resposta
header('Content-Type: application/json');

// Configurações para conexão com o banco de dados
define('HOST', 'localhost');
define('USER', 'root');
define('PASS', '');
define('BASE', 'semana21');

// Cria uma nova instância da classe mysqli para a conexão com o banco de dados
$con = new mysqli(HOST, USER, PASS, BASE);

// Array para armazenar a resposta que será convertida em JSON
$response = array();

// Verifica se houve erro na conexão com o banco de dados
if ($con->connect_error) {
    $response['error'] = true;
    $response['message'] = 'Erro ao conectar ao banco de dados: ' . $con->connect_error;
    echo json_encode($response);
    die(); // Encerra o script se houver um erro na conexão
}

try {
    // Endpoint para buscar um usuário por ID
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Decodifica os dados JSON da solicitação POST
        $data = json_decode(file_get_contents("php://input"));
        
        // Verifica se o JSON foi decodificado corretamente
        if ($data === null) {
            $response['error'] = true;
            $response['message'] = 'Erro ao decodificar o JSON.';
            echo json_encode($response);
            die();
        }
        
        $id = $data->id;

        // Verifica se o ID foi fornecido
        if (!isset($id)) {
            $response['error'] = true;
            $response['message'] = 'ID não fornecido.';
            echo json_encode($response);
            die();
        }

        // Utiliza consulta preparada para evitar injeção SQL
        $stmt = $con->prepare("SELECT * FROM usuarios WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Verifica se há resultados
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo json_encode($row);
        } else {
            // Retorna uma mensagem se o usuário não for encontrado
            echo json_encode(array('message' => 'Usuário não encontrado.'));
        }
    }
} catch (Exception $e) {
    // Trata exceções e retorna uma resposta de erro
    $response['error'] = true;
    $response['message'] = 'Erro: ' . $e->getMessage();
    echo json_encode($response);
    die();
} finally {
    // Fecha a conexão com o banco de dados
    $con->close();
}
?>
