<?php
$tasks = array(
    'Limpar o quarto',
    'Fazer compras',
    'Estudar programação',
    'Fazer exercícios',
    'Ler um livro',
    'Assistir a um filme',
    'Cozinhar uma refeição',
    'Aprender algo novo'
);

// Retorna uma tarefa aleatória do array
echo $tasks[array_rand($tasks)];
?>
