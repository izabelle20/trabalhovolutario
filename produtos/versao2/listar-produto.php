<?php
header('Content-Type: application/json');

$con = mysqli_connect("localhost", "root", "", "cadastro_produtos");

// Inicializar dados de resposta JSON
$dados = array();
$dados['erro'] = false;
$dados['mensagem'] = "";
$dados['produtos'] = array();

// Verificar se o parâmetro "id" está presente na URL
if (isset($_GET['id'])) {
    $produto_id = intval($_GET['id']);

    // Consultar produto com o ID fornecido
    $sql = "SELECT * FROM produtos WHERE id = $produto_id";
    $result = mysqli_query($con, $sql);

    // Verificar se o produto foi encontrado
    if (mysqli_num_rows($result) > 0) {
        $produto = mysqli_fetch_assoc($result);

        // Adicionar o produto aos dados de resposta
        $item = array(
            'id' => intval($produto['id']),
            'nome' => $produto['nome'],
            'descricao' => $produto['descricao'],
            'valor' => $produto['valor'],
            'status' => $produto['status']
        );

        $dados['produtos'] = $item;
    } else {
        $dados['erro'] = true;
        $dados['mensagem'] = "Nenhum produto encontrado com o ID $produto_id";
    }
} else {
    $dados['erro'] = true;
    $dados['mensagem'] = "Parâmetro 'id' ausente na URL";
}

// Retornar os dados como JSON
echo json_encode($dados);

// Fechar a conexão com o banco de dados
mysqli_close($con);
?>
