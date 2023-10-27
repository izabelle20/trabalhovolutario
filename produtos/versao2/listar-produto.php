<?php
header('Content-Type: application/json');

$con = mysqli_connect("localhost", "root", "", "cadastro_produtos");

// Inicializar dados de resposta JSON
$dados = array();
$dados['erro'] = false;
$dados['mensagem'] = "";
$dados['produtos'] = array();

$sql = "SELECT * FROM produtos";
$result = mysqli_query($con, $sql);

// Verificar se há produtos retornados
if (mysqli_num_rows($result) > 0) {
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
    $dados['erro'] = true;
    $dados['mensagem'] = "Nenhum produto encontrado";
}

// Retornar os dados como JSON
echo json_encode($dados);

// Fechar a conexão com o banco de dados
mysqli_close($con);
?>
