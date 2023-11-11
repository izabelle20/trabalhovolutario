<?php
// Set the content type to JSON
header('Content-Type: application/json');

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login_escola";

// Create a new mysqli connection
$con = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($con->connect_error) {
    $response = array(
        'error' => true,
        'message' => 'Conexão falhou: ' . $con->connect_error
    );
    echo json_encode($response);
    die();
}

// Handle CRUD operations based on the HTTP method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['acao']) && $data['acao'] === 'cadastrar') {
        // Cadastrar novo produto
        $nome = $data['nome'];
        $email = $data['email']; // Add email field
        $id = $data['id'];
        $disciplina = $data['disciplina']; // Add disciplina field

        // Prepare and execute the INSERT query
        $stmt = $con->prepare("INSERT INTO produtos (nome, email, id, disciplina) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nome, $email, $id, $disciplina);

        if ($stmt->execute()) {
            $response = array(
                'message' => 'Novo produto cadastrado com sucesso.'
            );
            echo json_encode($response);
        } else {
            $response = array(
                'error' => true,
                'message' => 'Erro ao cadastrar o produto: ' . $con->error
            );
            echo json_encode($response);
        }

        $stmt->close();
    } elseif (isset($data['acao']) && $data['acao'] === 'editar') {
        // Editar produto existente - Add your code here
    } elseif (isset($data['acao']) && $data['acao'] === 'excluir') {
        // Excluir produto - Add your code here
    } else {
        $response = array(
            'error' => true,
            'message' => 'Ação inválida. Forneça uma ação válida (cadastrar, editar ou excluir).'
        );
        echo json_encode($response);
    }
}

// Close the database connection
$con->close();
?>
