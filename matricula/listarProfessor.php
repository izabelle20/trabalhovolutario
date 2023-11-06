<?php
header('Content-Type: application/json');

$con = mysqli_connect("localhost", "root", "", "matricula");

// Inicializar dados de resposta JSON
$dados = array();
$dados['erro'] = false;
$dados['mensagem'] = "";
$dados['professores'] = array();

$sql = "SELECT * FROM professores";
$result = mysqli_query($con, $sql);

// Verificar se há professores retornados
if (mysqli_num_rows($result) > 0) {
    while ($professor = mysqli_fetch_assoc($result)) {
        // Adicionar cada professor aos dados de resposta
        $item = array(
            'id' => intval($professor['id']),
            'nome' => $professor['nome'],
            'disciplina' => $professor['disciplina'],
            'email' => $professor['email']
        );
        array_push($dados['professores'], $item);
    }
} else {
    $dados['erro'] = true;
    $dados['mensagem'] = "Nenhum professor encontrado";
}

// Retornar os dados como JSON
echo json_encode($dados);

// Fechar a conexão com o banco de dados
mysqli_close($con);
?>
