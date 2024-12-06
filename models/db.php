<?php
 // Cambia esto según tu configuración
 $host = 'localhost';
    $db = 'inventario';
    $user = 'root'; // Cambia esto según tu configuración
    $pass = '';
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
    }


function conectar()
{
    $host = 'localhost';
    $db = 'inventario';
    $user = 'root'; // Cambia esto según tu configuración
    $pass = '';
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
    }
    return $pdo ;
}
?>