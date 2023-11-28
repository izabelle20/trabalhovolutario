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

// Buscar Vendedores
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Preparar a consulta SQL para buscar vendedores
    $sql = "SELECT CODIGO_VENDEDOR, nome_vendedor, salario_fixo, faixa_comissao, sexo FROM vendedor";

    try {
        // Executar a consulta SQL
        $result = $mysqli->query($sql);

        if (!$result) {
            throw new Exception("Erro ao executar a consulta: " . $mysqli->error);
        }

        // Converter o resultado em um array associativo
        $vendedores = [];
        while ($row = $result->fetch_assoc()) {
            $vendedores[] = $row;
        }

        // Retornar uma resposta JSON com os vendedores encontrados
        echo json_encode(["status" => "success", "vendedores" => $vendedores]);
    } catch (Exception $e) {
        // Capturar exceções e retornar mensagem de erro
        echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    } finally {
        // Fechar a conexão
        $mysqli->close();
    }
}

?>
