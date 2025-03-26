<?php
require_once "db.php"; // Importa la conexión a la base de datos

$conn = $GLOBALS['conn'] ?? null;

if (!$conn) {
    die("Error: No se pudo establecer conexión con la base de datos.");
}

// Función para guardar mensaje en la base de datos
function guardarMensaje($conn, $mensaje) {
    $sql = "INSERT INTO mensajes (mensaje) VALUES (:mensaje)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':mensaje', $mensaje, PDO::PARAM_STR);
    $stmt->execute();
}

// ✅ **Si la solicitud es `POST` (desde PowerShell)**
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    header("Content-Type: application/json"); // Formato JSON para PowerShell
    $data = json_decode(file_get_contents("php://input"), true);
    
    if (!empty($data["mensaje"])) {
        $mensaje = htmlspecialchars($data["mensaje"]);
        guardarMensaje($conn, $mensaje);
        
        // Guardar temporalmente para el navegador
        file_put_contents("mensaje_temp.txt", $mensaje);

        echo json_encode(["status" => "success", "mensaje" => $mensaje]);
    } else {
        echo json_encode(["status" => "error", "message" => "No se recibió ningún mensaje."]);
    }
    exit();
}

// ✅ **Si la solicitud es `GET` (desde el navegador)**
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $mensaje = null;

    if (!empty($_GET["mensaje"])) {
        $mensaje = htmlspecialchars($_GET["mensaje"]);
        guardarMensaje($conn, $mensaje);
    } elseif (file_exists("mensaje_temp.txt")) {
        $mensaje = file_get_contents("mensaje_temp.txt");
        unlink("mensaje_temp.txt");
    }

    if ($mensaje) {
        echo "<h2>Mensaje Recibido:</h2><p><strong>$mensaje</strong></p>";
    } else {
        echo "Por favor, envía un mensaje como parámetro en la URL. Ejemplo: ?mensaje=Hola";
    }
}
?>
