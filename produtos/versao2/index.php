<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <title>Produtos</title>
</head>
<body>

    <!-- Cabeçalho da página -->
    <div class="header">
        <h1>Minha Loja</h1>
        <!-- Botões de navegação -->
        <div>
            <a class="btn" href="novo-produto.php">Novo Produto</a>
            <a class="btn" href="listar-produto.php">Listar Produtos</a>
        </div>
    </div>

    <!-- Conteúdo principal -->
    <div class="container">
        <div class="row">
            <div class="col mt-5">
                <?php
                // Inclui o arquivo config.php que provavelmente contém configurações comuns
                include("config.php");

                // Utiliza um switch para determinar qual conteúdo incluir com base na variável 'page'
                switch(@$_REQUEST["page"]){
                    case "novo":
                        // Inclui o arquivo novo-produto.php
                        include("novo-produto.php");
                    break;
                    case "listar":
                        // Inclui o arquivo listar-produto.php
                        include("listar-produto.php");
                    break;
                    case "salvar":
                        // Inclui o arquivo salvar-produto.php
                        include("salvar-produto.php");
                    break;
                    case "editar":
                        // Inclui o arquivo editar-produto.php
                        include("editar-produto.php");
                    break;
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
