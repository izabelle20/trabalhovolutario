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

// Atualizar Vendedor
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Decodificar o corpo da solicitação JSON
    $data = json_decode(file_get_contents('php://input'), true);

    // Validar dados
    if (
        isset($data['nome_vendedor']) &&
        isset($data['salario_fixo']) &&
        isset($data['faixa_comissao']) &&
        isset($data['sexo']) &&
        isset($data['CODIGO_VENDEDOR'])
    ) {
        // Preparar a consulta SQL para atualizar um vendedor existente
        $sql = "UPDATE vendedor SET nome_vendedor = ?, salario_fixo = ?, faixa_comissao = ?, sexo = ? WHERE CODIGO_VENDEDOR = ?";

        try {
            // Usar declarações preparadas para evitar injeção de SQL
            $stmt = $mysqli->prepare($sql);

            if (!$stmt) {
                throw new Exception("Erro na preparação da consulta: " . $mysqli->error);
            }

            // Liga os parâmetros
            $stmt->bind_param(
                'sdssi', // Ajustado para refletir os tipos corretos dos campos na tabela
                $data['nome_vendedor'],
                $data['salario_fixo'],
                $data['faixa_comissao'],
                $data['sexo'],
                $data['CODIGO_VENDEDOR']
            );

            // Executa a consulta
            if (!$stmt->execute()) {
                throw new Exception("Erro ao executar a consulta: " . $stmt->error);
            }

            // Retornar uma resposta JSON com a mensagem
            echo json_encode(["status" => "success", "message" => "Vendedor atualizado com sucesso!"]);
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
    } else {
        // Dados incompletos
        echo json_encode(["status" => "error", "message" => "Dados incompletos"]);
    }
}
?>
