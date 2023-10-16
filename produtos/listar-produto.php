<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Produto</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }
        .btn {
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            color: #fff;
        }
        .btn-success {
            background-color: #28a745;
        }
        .btn-danger {
            background-color: #dc3545;
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }
        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }
    </style>
</head>

<h1>Listar Produto</h1>
<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "cadastro_produtos"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$sql = "SELECT * FROM produtos";
$res = $conn->query($sql);
$qtd = $res->num_rows;

if ($qtd > 0) {
    echo "<table class='table table-hover table-striped table-bordered'>";
    echo "<tr>";
    echo "<th>#</th>";
    echo "<th>Nome</th>";
    echo "<th>Descrição</th>";
    echo "<th>Valor</th>";
    echo "<th>Status</th>";
    echo "<th>Ações</th>";
    echo "</tr>";
    while ($row = $res->fetch_assoc()) {
        echo "<tr>";
        echo "<td>ID: " . $row['id'] . "</td>";
        echo "<td>Nome: " . $row['nome'] . "</td>";
        echo "<td>Descrição: " . $row['descricao'] . "</td>";
        echo "<td>Valor: " . $row['valor'] . "</td>";
        echo "<td>Status: " . $row['status'] . "</td>";
        echo "<td>
                <button onclick=\"location.href='editar-produto.php?id=".$row['id']."';\" class='btn btn-success'>Editar</button>
                <button onclick=\"if(confirm('Tem certeza que deseja excluir?')){location.href='?page=salvar&acao=excluir&id=".$row['id']."';}else{false;}\" class='btn btn-danger'>Excluir</button>
            </td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p class='alert alert-danger'>Não foram encontrados resultados!</p>";
}

$conn->close(); 
?>
