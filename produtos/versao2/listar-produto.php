<?php
// Configuração do cabeçalho para indicar que a resposta é em formato JSON
header('Content-Type: application/json');

// Conectar ao banco de dados (substitua os valores pelos seus)
$con = mysqli_connect("localhost", "root", "", "cadastro_produtos");

// Inicializar dados de resposta JSON
$dados = array();
$dados['erro'] = false; // Indica se houve algum erro durante a execução
$dados['mensagem'] = ""; // Mensagem associada ao resultado da operação
$dados['produtos'] = array(); // Array que conterá os dados dos produtos

// Consultar todos os produtos na tabela "produtos"
$sql = "SELECT * FROM produtos";
$result = mysqli_query($con, $sql);

// Verificar se há produtos retornados
if (mysqli_num_rows($result) > 0) {
    // Iterar sobre cada linha de resultado
    while ($produto = mysqli_fetch_assoc($result)) {
        // Adicionar cada produto aos dados de resposta
        $item = array(
            'id' => intval($produto['id']),
            'nome' => $produto['nome'],
            'descricao' => $produto['descricao'],
            'valor' => $produto['valor'],
            'status' => $produto['status']
        );
        array_push($dados['produtos'], $item);
    }
} else {
    // Se nenhum produto foi encontrado, configurar dados de erro
    $dados['erro'] = true;
    $dados['mensagem'] = "Nenhum produto encontrado";
}

// Retornar os dados como JSON
echo json_encode($dados);

// Fechar a conexão com o banco de dados
mysqli_close($con);
?>
