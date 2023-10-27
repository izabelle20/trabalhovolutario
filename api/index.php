<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
        }

        table {
            border-collapse: collapse;
            width: 50%;
            margin-top: 30px;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        h1 {
            text-align: center;
        }
    </style>
</head>
<body>

    <header>
        <h1>Lista de Produtos</h1>
    </header>

    <?php
    $con = mysqli_connect("localhost", "root", "", "cadastro_produtos");

    $dados = array();

    $sql = "SELECT * FROM produtos";

    $result = mysqli_query($con, $sql);

    if(mysqli_num_rows($result) > 0){
        echo "<table>";
        echo "<tr><th>ID</th><th>Nome</th><th>Descrição</th><th>Valor</th><th>Status</th><th>Editar</th><th>Excluir</th></tr>";
        while($user = mysqli_fetch_array($result)){
            echo "<tr>";
            echo "<td>" . intval($user['id']) . "</td>";
            echo "<td>" . $user['nome'] . "</td>";
            echo "<td>" . $user['descricao'] . "</td>";
            echo "<td>" . $user['valor'] . "</td>";
            echo "<td>" . $user['status'] . "</td>";
            echo "<td><form action='editar-produto.php' method='get'><input type='hidden' name='id' value='".$user['id']."'><input type='submit' value='Editar'></form></td>";
            echo "<td><form action='excluir-produto.php' method='post'><input type='hidden' name='id' value='".$user['id']."'><input type='submit' value='Excluir'></form></td>";
            
            echo "</tr>";
            
        }
        echo "</table>";
    }else{
        echo '<p style="text-align: center;">Nenhum produto encontrado.</p>';
        exit;
    }
    ?>

</body>
</html>
