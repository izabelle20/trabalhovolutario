<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos</title>
</head>
<body>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .header {
            background-color: #f8f9fa;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header h1 {
            margin: 0;
        }
        .header .btn {
            padding: 8px 20px;
            background-color: palevioletred;
            color: #ffffff;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            margin-left: 10px;
        }
        .header .btn:hover {
            background-color: #92425c;
        }
    </style>

    <!--HEADER-->
    <div class="header">
        <h1>Minha Loja</h1>
        <div>
            <a class="btn" href="novo-produto.html">Novo Produto</a>
            <a class="btn" href="listar-produto.php">Listar Produtos</a>
        </div>
    </div>

    <!--MIOLO-->
    <div class="container">
        <div class="row">
            <div class="col mt-5">
                <?php
                include("config.php");
                switch(@$_REQUEST["page"]){
                    case "novo":
                        include("novo-produto.php");
                    break;
                    case "listar":
                        include("listar-produto.php");
                    break;
                    case "salvar":
                        include("salvar-produto.php");
                    break;
                    case "editar":
                        include("editar-produto.php");
                    break;
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
