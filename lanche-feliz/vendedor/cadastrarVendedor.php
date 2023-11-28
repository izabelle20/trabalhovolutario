<?php

// Substitua as configurações do banco de dados pelos valores corretos
$hostname = "localhost";
$username = "root";
$password = "";
$database = "quitanda";

// Conecta ao banco de dados
$mysqli = new mysqli($hostname, $username, $password, $database);

// Verifica a conexão
if ($mysqli->connect_error) {
    die("Conexão falhou: " . $mysqli->connect_error);
}

// Cadastrar Vendedor
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Decodificar o corpo da solicitação JSON
    $data = json_decode(file_get_contents('php://input'), true);

    // Preparar a consulta SQL para inserir um novo vendedor
    $sql = "INSERT INTO vendedor (CODIGO_VENDEDOR, nome_vendedor, salario_fixo, faixa_comissao, sexo) VALUES (?, ?, ?, ?, ?)";

    try {
        // Usar declarações preparadas para evitar injeção de SQL
        $stmt = $mysqli->prepare($sql);

        if (!$stmt) {
            throw new Exception("Erro na preparação da consulta: " . $mysqli->error);
        }

        // Liga os parâmetros
        $stmt->bind_param(
            'isdss', // Corrigido para refletir o número correto de placeholders
            $data['CODIGO_VENDEDOR'],
            $data['nome_vendedor'],
            $data['salario_fixo'],
            $data['faixa_comissao'],
            $data['sexo']
        );

        // Executa a consulta
        if (!$stmt->execute()) {
            throw new Exception("Erro ao executar a consulta: " . $stmt->error);
        }

        // Obter o ID do vendedor recém-criado
        $id = $mysqli->insert_id;

        // Retornar uma resposta JSON com a mensagem e o ID do vendedor
        echo json_encode(["status" => "success", "message" => "Vendedor cadastrado com sucesso!", "id" => $id]);
    } catch (Exception $e) {
        // Capturar exceções e retornar mensagem de erro
        echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    } finally {
        // Fechar a declaração e a conexão
        if ($stmt) {
            $stmt->close();
        }
        $mysqli->close();
    }
}
?>
