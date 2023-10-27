<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto</title>
    <style>
        /* Estilos CSS aqui */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
        }

        input[type="text"],
        textarea,
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            float: right;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cadastro_produtos";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if (isset($_REQUEST["id"])) {
    $id = $conn->real_escape_string($_REQUEST["id"]);
    $sql = "SELECT * FROM produtos WHERE id='$id'";
    $res = $conn->query($sql);

    if ($res && $res->num_rows > 0) {
        $row = $res->fetch_assoc();
        ?>
        <form action="salvar-produto.php" method="POST">
            <input type="hidden" name="acao" value="editar">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <div>
                <label>Nome</label>
                <input type="text" name="nome" value="<?php echo htmlspecialchars($row['nome']); ?>" required>
            </div>

            <div>
                <label>Descrição:</label><br>
                <textarea name="descricao" rows="4" cols="50"><?php echo htmlspecialchars($row['descricao']); ?></textarea>
            </div>

            <div>
                <label>Valor:</label><br>
                <input type="text" name="valor" value="<?php echo htmlspecialchars($row['valor']); ?>" required>
            </div>

            <div>
                <label>Status:</label><br>
                <select name="status">
                    <option value="Ativo" <?php if ($row['status'] == 'Ativo') echo 'selected'; ?>>Ativo</option>
                    <option value="Inativo" <?php if ($row['status'] == 'Inativo') echo 'selected'; ?>>Inativo</option>
                </select>
            </div>

            <div>
                <button type="submit">Enviar</button>
            </div>
        </form>
        <?php
    } else {
        echo "<p>Produto não encontrado!</p>";
    }
    $res->close();
} else {
    echo "<p>ID do produto não especificado!</p>";
}
$conn->close();
?>

</body>
</html>
