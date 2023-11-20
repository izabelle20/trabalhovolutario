<?php
// Configuração do cabeçalho para indicar que a resposta é em formato JSON
header('Content-Type: application/json');

// Configuração das informações de conexão ao banco de dados
$con = mysqli_connect("localhost", "root", "", "matricula");

// Inicializar dados de resposta JSON
$dados = array();
$dados['erro'] = false;
$dados['mensagem'] = "";
$dados['professores'] = array();

// Consulta SQL para selecionar todos os professores
$sql = "SELECT * FROM professores";
$result = mysqli_query($con, $sql);

// Verificar se há professores retornados
if (mysqli_num_rows($result) > 0) {
    // Iterar sobre os resultados e adicionar cada professor aos dados de resposta
    while ($professor = mysqli_fetch_assoc($result)) {
        $item = array(
            'id' => intval($professor['id']),
            'nome' => $professor['nome'],
            'disciplina' => $professor['disciplina'],
            'email' => $professor['email']
        );
        array_push($dados['professores'], $item);
    }
} else {
    // Configurar dados de erro se nenhum professor for encontrado
    $dados['erro'] = true;
    $dados['mensagem'] = "Nenhum professor encontrado";
}

// Retornar os dados como JSON
echo json_encode($dados);

// Fechar a conexão com o banco de dados
mysqli_close($con);
?>
