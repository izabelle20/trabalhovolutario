<?php
// Configuração do cabeçalho para indicar que a resposta é em formato JSON
header('Content-Type: application/json');

// Configuração das informações de conexão ao banco de dados
$con = mysqli_connect("localhost", "root", "", "matricula");

// Inicializar dados de resposta JSON
$dados = array();
$dados['erro'] = false;
$dados['mensagem'] = "";
$dados['alunos'] = array();

// Consulta SQL para selecionar todos os alunos
$sql = "SELECT * FROM alunos";
$result = mysqli_query($con, $sql);

// Verificar se há alunos retornados
if (mysqli_num_rows($result) > 0) {
    // Iterar sobre os resultados e adicionar cada aluno aos dados de resposta
    while ($data = mysqli_fetch_assoc($result)) {
        $item = array(
            'id' => $data['id'],
            'nome_aluno' => $data['nome_aluno'],
            'serie' => $data['serie'],
            'idade' => $data['idade'],
            'curso' => $data['curso'],
            'periodo' => $data['periodo'],
            'campus' => $data['campus'],
            'nome_professor' => $data['nome_professor'],
            'matricula' => $data['matricula']
        );
        array_push($dados['alunos'], $item);
    }
} else {
    // Configurar dados de erro se nenhum aluno for encontrado
    $dados['erro'] = true;
    $dados['mensagem'] = "Nenhum aluno encontrado";
}

// Retornar os dados como JSON
echo json_encode($dados);

// Fechar a conexão com o banco de dados
mysqli_close($con);
?>
