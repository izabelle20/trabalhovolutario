<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matricula escolar</title>
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
        <h1>Escola Imaginaria</h1>
        <div>
            <a class="btn" href="novaMatricula.php">Nova matricula</a>
            <a class="btn" href="novoProfessor.php">Novo professor</a>
            <a class="btn" href="listarAlunos.php">Listar Alunos</a>
            <a class="btn" href="listarProfessor.php">Listar Professor</a>
        </div>
    </div>

    <!--MIOLO-->
    <div class="container">
        <div class="row">
            <div class="col mt-5">
                <?php
                include("config.php");
                switch(@$_REQUEST["page"]){
                    case "novaMatricula":
                        include("novaMatricula.php");
                    break;
                    case "novoProfessor":
                        include("novoProfessor.php");
                    break;
                    case "listarAluno":
                        include("listarAlunos.php");
                    break;
                    case "listarProfessor":
                        include("listarProfessor.php");
                    break;
                    case "salvar":
                        include("salvarMatricula.php");
                    break;
                    case "editar":
                        include("editarMatricula.php");
                    break;
                    
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
