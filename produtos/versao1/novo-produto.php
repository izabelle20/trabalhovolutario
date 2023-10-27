<?php
header('Content-Type: application/json');

define('HOST', 'localhost');
define('USER', 'root');
define('PASS', '');
define('BASE', 'cadastro_produtos');

$con = new mysqli(HOST, USER, PASS, BASE);

$response = array();

if ($con->connect_error) {
    $response['error'] = true;
    $response['message'] = 'Erro ao conectar ao banco de dados: ' . $con->connect_error;
    echo json_encode($response);
    die();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['nome']) && isset($data['descricao']) && isset($data['valor']) && isset($data['status'])) {
        $nome = $data['nome'];
        $descricao = $data['descricao'];
        $valor = $data['valor'];
        $status = $data['status'];

        $file = 'produtos.json';
        if (!file_exists($file)) {
            file_put_contents($file, '[]');
        }

        $jsonString = file_get_contents($file);
        $data = json_decode($jsonString, true);

        $newProduct = array(
            'nome' => $nome,
            'descricao' => $descricao,
            'valor' => $valor,
            'status' => $status
        );

        $data[] = $newProduct;

        $newJsonString = json_encode($data, JSON_PRETTY_PRINT);
        file_put_contents($file, $newJsonString);

        $response['success'] = true;
        $response['message'] = 'Novo produto cadastrado com sucesso.';
    } else {
        $response['error'] = true;
        $response['message'] = 'Dados de produto ausentes. Por favor, forneça todos os campos necessários.';
    }
} else {
    $response['error'] = true;
    $response['message'] = 'Método de solicitação inválido. Apenas o método POST é permitido.';
}

echo json_encode($response);

$con->close();
?>
