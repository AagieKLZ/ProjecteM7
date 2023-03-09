<?php
// Configuracio de la conexio a la db
$usuari = "root";
$contrasenya = "123321";
$db = "tenfe";
$host = "localhost:3306";

// Creem la conexió
try {
    $bd = new PDO('mysql:host=' . $host . ';dbname=' . $db, $usuari, $contrasenya);
    if (isset($_GET['debug'])) {
        echo "Conexio a la base de dades correcta";
    }

    // Executem la query que crea les taules
    $sql = file_get_contents('createTables.sql');
    $bd->exec($sql);
    if (isset($_GET['debug'])) {
        echo "Taules creades correctament (si no existien)";
    }

} catch (PDOException $e) {
    echo "Error al connectar la base de dades!: " . $e->getMessage() . "<n/>";
    die();
}