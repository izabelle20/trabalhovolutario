<?php
// Define o cabeçalho HTTP para indicar que a resposta é em formato JSON
header('Content-Type: application/json');

// Configurações de acesso ao banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "matricula";

// Conecta ao banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Inicializa a resposta JSON
$response = array();

// Verifica se houve falha na conexão ao banco de dados
if ($conn->connect_error) {
    $response['error'] = true;
    $response['message'] = 'Conexão falhou: ' . $conn->connect_error;
    echo json_encode($response);
    die(); // Encerra o script se a conexão falhar
}

// Verifica se o parâmetro 'id' foi fornecido na URL e não está vazio
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    // Utiliza uma instrução preparada para prevenir injeção de SQL
    $sql = "SELECT * FROM alunos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id); // Assume que 'id' é um número inteiro

    // Executa a instrução preparada
    if ($stmt->execute()) {
        $result = $stmt->get_result();

        // Verifica se há registros retornados pela consulta
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Cria a resposta JSON, incluindo o registro completo para depuração
            $response = array(
                'debug_row' => $row  // Inclui o registro completo para depuração
            );

            echo json_encode($response);
        } else {
            // Configura dados de erro se nenhum registro for encontrado
            $response = array(
                'error' => true,
                'message' => 'Nenhuma matrícula encontrada com este ID.'
            );
            echo json_encode($response);
        }
    } else {
        // Configura dados de erro se houver falha na execução da consulta
        $response = array(
            'error' => true,
            'message' => 'Erro ao executar a consulta: ' . $stmt->error
        );
        echo json_encode($response);
    }

    // Fecha a instrução preparada
    $stmt->close();
} else {
    // Configura dados de erro se o parâmetro 'id' não for especificado
    $response = array(
        'error' => true,
        'message' => 'ID da matrícula não especificado.'
    );
    echo json_encode($response);
}

// Fecha a conexão com o banco de dados
$conn->close();
?>
