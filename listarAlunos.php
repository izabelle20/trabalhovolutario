<?php
header('Content-Type: application/json');

$con = mysqli_connect("localhost", "root", "", "matricula");

// Inicializar dados de resposta JSON
$dados = array();
$dados['erro'] = false;
$dados['mensagem'] = "";
$dados['alunos'] = array();

$sql = "SELECT * FROM alunos";
$result = mysqli_query($con, $sql);

// Verificar se há alunos retornados
if (mysqli_num_rows($result) > 0) {
    while ($aluno = mysqli_fetch_assoc($result)) {
        // Adicionar cada aluno aos dados de resposta
        $item = array(
            'id' => intval($aluno['id']),
            'nome' => $aluno['nome'],
            'idade' => $aluno['idade'],
            'serie' => $aluno['serie'],
            'curso' => $aluno['curso'],
            'campus' => $aluno['campus'],
            'periodo' => $aluno['periodo'],
            'nome_do_professor' => $aluno['nome_do_professor']
        );
        array_push($dados['alunos'], $item);
    }
} else {
    $dados['erro'] = true;
    $dados['mensagem'] = "Nenhum aluno encontrado";
}

// Retornar os dados como JSON
echo json_encode($dados);

// Fechar a conexão com o banco de dados
mysqli_close($con);
?>
