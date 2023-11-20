<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login_escola";

// Conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['psw'];

    // Consulta preparada
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = ? AND senha = ?");
    $stmt->bind_param("ss", $email, $senha);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Se as credenciais estiverem corretas, você pode redirecionar o usuário para uma página de perfil ou para a página inicial do site.
        header("Location: pagina_perfil.php");
        exit();
    } else {
        // Se as credenciais estiverem incorretas, você pode redirecionar o usuário de volta para a página de login ou exibir uma mensagem de erro.
        header("Location: login.php?erro=Credenciais%20inválidas");
        exit();
    }
}
?>
