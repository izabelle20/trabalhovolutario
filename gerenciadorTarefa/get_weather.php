<?php
$apiKey = 'SUA_CHAVE_DE_API_DO_OPENWEATHERMAP'; // Substitua pela sua chave de API
$city = $_GET['city'];

$url = "https://api.openweathermap.org/data/2.5/weather?q=$city&appid=$apiKey&units=metric";

$response = file_get_contents($url);
header('Content-Type: application/json');
echo $response;