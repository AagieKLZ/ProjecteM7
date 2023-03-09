<?php
// Configuracio de la conexio a la db
$usuari = "root";
$contrasenya = "123321";
$db = "tenfe";
$host = "localhost:3306";

// Creem la conexio
try {
    $bd = new PDO('mysql:host=' . $host . ';dbname=' . $db, $usuari, $contrasenya);
    if (isset($_GET['debug'])) {
        echo "Conexio a la base de dades correcta";
    }
} catch (PDOException $e) {
    echo "Error al connectar la base de dades!: " . $e->getMessage() . "<n/>";
    die();
}