<?php
// Define o tipo de conteúdo como JSON para a resposta
header('Content-Type: application/json');

// Configurações para conexão com o banco de dados
define('HOST', 'localhost');
define('USER', 'root');
define('PASS', '');
define('BASE', 'cadastro_produtos');

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

// Verifica se a solicitação é do tipo POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém os dados JSON da solicitação POST e decodifica
    $data = json_decode(file_get_contents('php://input'), true);

    // Verifica se a ação está presente e é válida
    if (isset($data['acao'])) {
        if ($data['acao'] === 'cadastrar') {
            cadastrarProduto($data, $con, $response);
        } elseif ($data['acao'] === 'salvar') {
            salvarProduto($data, $con, $response);
        } else {
            // Configura a resposta de erro se a ação não for válida
            $response['error'] = true;
            $response['message'] = 'Ação inválida. Apenas as ações "salvar" e "cadastrar" são permitidas.';
        }
    } else {
        // Configura a resposta de erro se a ação não estiver presente
        $response['error'] = true;
        $response['message'] = 'Ação ausente. Por favor, forneça a ação "salvar" ou "cadastrar".';
    }
} else {
    // Configura a resposta de erro se o método de solicitação não for POST
    $response['error'] = true;
    $response['message'] = 'Método de solicitação inválido. Apenas o método POST é permitido. Utilize o app (POSTMAN) para adicionar um novo produto.';
}

// Converte a resposta em JSON e a exibe
echo json_encode($response);

// Fecha a conexão com o banco de dados
$con->close();

// Função para cadastrar um produto
function cadastrarProduto($data, $con, &$response) {
    // Verifica se os campos necessários estão presentes nos dados
    if (isset($data['nome']) && isset($data['descricao']) && isset($data['valor']) && isset($data['status'])) {
        // Atribui valores às variáveis a partir dos dados recebidos
        $nome = $con->real_escape_string($data['nome']); // Evita injeção de SQL
        $descricao = $con->real_escape_string($data['descricao']);
        $valor = $data['valor'];
        $status = $data['status'];

        // Constrói e executa a consulta SQL para inserir os dados no banco de dados
        $sql = "INSERT INTO produtos (nome, descricao, valor, status) VALUES ('$nome', '$descricao', $valor, '$status')";
        if ($con->query($sql)) {
            // Configura a resposta de sucesso
            $response['success'] = true;
            $response['message'] = 'Novo produto cadastrado com sucesso.';
        } else {
            // Configura a resposta de erro se a inserção falhar
            $response['error'] = true;
            $response['message'] = 'Erro ao cadastrar novo produto: ' . $con->error;
        }
    } else {
        // Configura a resposta de erro se os campos necessários estão ausentes
        $response['error'] = true;
        $response['message'] = 'Dados de produto ausentes. Por favor, forneça todos os campos necessários.';
    }
}

// Função para salvar (editar) um produto
function salvarProduto($data, $con, &$response) {
    // Verifica se os campos necessários e o ID do produto estão presentes nos dados
    if (isset($data['id']) && isset($data['nome']) && isset($data['descricao']) && isset($data['valor']) && isset($data['status'])) {
        // Atribui valores às variáveis a partir dos dados recebidos
        $id = intval($data['id']);
        $nome = $con->real_escape_string($data['nome']); // Evita injeção de SQL
        $descricao = $con->real_escape_string($data['descricao']);
        $valor = $data['valor'];
        $status = $data['status'];

        // Constrói e executa a consulta SQL para atualizar os dados no banco de dados
        $sql = "UPDATE produtos SET nome='$nome', descricao='$descricao', valor=$valor, status='$status' WHERE id=$id";
        if ($con->query($sql)) {
            // Configura a resposta de sucesso
            $response['success'] = true;
            $response['message'] = 'Produto salvo com sucesso.';
        } else {
            // Configura a resposta de erro se a atualização falhar
            $response['error'] = true;
            $response['message'] = 'Erro ao salvar produto: ' . $con->error;
        }
    } else {
        // Configura a resposta de erro se os campos necessários ou o ID estão ausentes
        $response['error'] = true;
        $response['message'] = 'Dados de produto ou ID ausentes. Por favor, forneça todos os campos necessários e o ID do produto.';
    }
}

