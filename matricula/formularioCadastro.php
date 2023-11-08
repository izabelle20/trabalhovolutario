
<!DOCTYPE html>
<html>
<head>
    <title>Escola Imaginaria</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>

<div class="container">
    <h2>Cadastro de Usuário</h2>

    <form action="cadastro.php" method="post">
        <label for="nome">Nome:</label><br>
        <input type="text" id="nome" name="nome"><br><br>
        <label for="email">E-mail:</label><br>
        <input type="text" id="email" name="email"><br><br>
        <label for="senha">Senha:</label><br>
        <input type="password" id="senha" name="senha"><br><br>
        <input type="submit" value="Cadastrar">
    </form>
</div>

</body>
</html>
