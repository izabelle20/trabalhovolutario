<!DOCTYPE html>
<html>
<head>
    <title>Escola Imaginária</title>
    <!-- Inclusão do arquivo de estilo CSS para estilização da página -->
    <link rel="stylesheet" type="text/css" href="paginaCadastro.css">
</head>
<body>

<!-- Container principal da página -->
<div class="container">
    <!-- Título do formulário -->
    <h2>Cadastro de Usuário</h2>

    <!-- Formulário de cadastro com método POST, redirecionando para "cadastro.php" -->
    <form action="cadastro.php" method="post">
        <!-- Campo de entrada para o nome -->
        <label for="nome">Nome:</label><br>
        <input type="text" id="nome" name="nome"><br><br>

        <!-- Campo de entrada para o e-mail -->
        <label for="email">E-mail:</label><br>
        <input type="text" id="email" name="email"><br><br>

        <!-- Campo de entrada para a senha -->
        <label for="senha">Senha:</label><br>
        <input type="password" id="senha" name="senha"><br><br>

        <!-- Botão de envio do formulário -->
        <input type="submit" value="Cadastrar">
    </form>
</div>

</body>
</html>
