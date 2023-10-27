<?php
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];
$request = explode('/', trim($_SERVER['PATH_INFO'],'/'));

// Implemente suas operações GET, PUT, POST e DELETE aqui

// Exemplo de resposta para todas as solicitações
echo json_encode(array("message" => "Requisição recebida."));
?>
