<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Configurações iniciais, como charset e viewport -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Inclusão do arquivo de estilo CSS para estilização da página de login -->
    <link rel="stylesheet" href="login.css">
    <!-- Título da página -->
    <title>Escola Imaginária</title>
</head>
<body>
    <!-- Container principal da página -->
    <div class="container">
        <!-- Título do formulário de login -->
        <h2>Login</h2>
        <!-- Formulário de login com redirecionamento para "process_login.php" -->
        <form action="process_login.php" method="post" id="loginForm">
            <!-- Campo de entrada para o e-mail -->
            <label for="email">E-mail:</label><br>
            <input type="email" placeholder="E-mail" name="email" required><br>
            <!-- Campo de entrada para a senha -->
            <label for="psw">Senha:</label><br>
            <input type="password" placeholder="Senha" name="psw" required><br>
            <!-- Botão de envio do formulário -->
            <button type="submit" id="loginButton">Login</button>
        </form>
        <!-- Link para a página de cadastro -->
        <div class="switch">
            <p>Não tem uma conta? <a href="formularioCadastro.php">Cadastre-se</a></p>
        </div>
    </div>

    <!-- Script JavaScript para enviar o formulário via AJAX (é uma técnica de programação web que permite a comunicação assíncrona entre o navegador e o servidor) -->
    <script>
        document.getElementById('loginForm').addEventListener('submit', function (e) {
            e.preventDefault();
            // Obter o formulário e os dados do formulário
            let form = e.target;
            let formData = new FormData(form);

            // Enviar os dados do formulário via fetch
            fetch(form.action, {
                method: form.method,
                body: formData
            }).then(response => {
                // Redirecionar para a URL fornecida pela resposta, se houver redirecionamento
                if (response.redirected) {
                    window.location.href = response.url;
                }
            }).catch(error => {
                // Lidar com erros durante o envio do formulário
                console.error('Erro no envio do formulário:', error);
            });
        });
    </script>
</body>
</html>
