<?php

$host = 'localhost';
$dbname = 'girls_detalles';
$username = 'root';
$password = '';

try {
   
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4"; 
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, 
        PDO::ATTR_EMULATE_PREPARES => false, 
    ];

    $conn = new PDO($dsn, $username, $password, $options);

  
 
} catch (PDOException $e) {
   
    die("Error en la conexión: " . $e->getMessage());
}
