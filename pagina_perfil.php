<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="pagina_perfil.css">
    <title>Escola Imaginária</title>
</head>
<body>
    <div class="butoes-centrais">
        <h4>Bem-vindo(a) a Escola Imaginaria!</h4>
        <a class="btn" href="novaMatricula.php">Nova matricula</a>
        <a class="btn" href="novoProfessor.php">Novo professor</a>
        <a class="btn" href="listarAlunos.php">Listar Alunos</a>
        <a class="btn" href="listarProfessor.php">Listar Professor</a>
    </div>

    <!--MIOLO-->
    <div class="">
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
