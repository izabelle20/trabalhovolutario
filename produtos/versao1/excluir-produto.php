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

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    // SQL para excluir um registro
    $sql = "DELETE FROM produtos WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "Produto excluído com sucesso";
    } else {
        echo "Erro ao excluir o produto: " . $conn->error;
    }
} else {
    echo "ID do produto não especificado. A exclusão não foi realizada.";
}

$conn->close();
?>
