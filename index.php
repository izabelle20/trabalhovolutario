<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <title>Escola Imaginária</title>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form action="process_login.php" method="post" id="loginForm">
            <label for="email">E-mail:</label><br>
            <input type="email" placeholder="E-mail" name="email" required><br>
            <label for="psw">Senha:</label><br>
            <input type="password" placeholder="Senha" name="psw" required><br>
            <button type="submit" id="loginButton">Login</button>
        </form>
        <div class="switch">
            <p>Não tem uma conta? <a href="formularioCadastro.php">Cadastre-se</a></p>
        </div>
    </div>
    
    <script>
        document.getElementById('loginForm').addEventListener('submit', function (e) {
            e.preventDefault();
            let form = e.target;
            let formData = new FormData(form);

            fetch(form.action, {
                method: form.method,
                body: formData
            }).then(response => {
                if (response.redirected) {
                    window.location.href = response.url;
                }
            }).catch(error => {
                console.error('Erro no envio do formulário:', error);
            });
        });
    </script>
</body>
</html>
