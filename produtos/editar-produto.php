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
            <div class="mb-3">
                <label>Nome</label>
                <input type="text" name="nome" value="<?php echo htmlspecialchars($row['nome']); ?>" required>
            </div>

            <div class="mb-3">
                <label>Descrição:</label><br>
                <textarea name="descricao" rows="4" cols="50"><?php echo htmlspecialchars($row['descricao']); ?></textarea>
            </div>

            <div class="mb-3">
                <label>Valor:</label><br>
                <input type="text" name="valor" value="<?php echo htmlspecialchars($row['valor']); ?>" required>
            </div>

            <div class="mb-3">
                <label>Status:</label><br>
                <select name="status">
                    <option value="Ativo" <?php if ($row['status'] == 'Ativo') echo 'selected'; ?>>Ativo</option>
                    <option value="Inativo" <?php if ($row['status'] == 'Inativo') echo 'selected'; ?>>Inativo</option>
                </select>
            </div>

            <div class="mb-3">
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
