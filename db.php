<?php
// Nombre del archivo de la base de datos en la misma carpeta que index.php
$db_file = __DIR__ . "/mensajes_db.sqlite";

try {
    // Crear conexión a SQLite con PDO
    $conn = new PDO("sqlite:" . $db_file);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Hacer `$conn` accesible globalmente
    $GLOBALS['conn'] = $conn;

    // Crear la tabla si no existe
    $query = "CREATE TABLE IF NOT EXISTS mensajes (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        mensaje TEXT NOT NULL,
        fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $conn->exec($query);

} catch (PDOException $e) {
    die("Error de conexión a SQLite: " . $e->getMessage());
}
?>
