<?php
// Configuración de la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "maymay_coffee";

try {
    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        throw new Exception("La conexión a la base de datos falló: " . $conn->connect_error);
    }

    // Validar datos del formulario
    $nombre = isset($_POST['nombre']) ? htmlspecialchars(trim($_POST['nombre'])) : null;
    $email = isset($_POST['email']) ? filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL) : null;
    $telefono = isset($_POST['telefono']) ? htmlspecialchars(trim($_POST['telefono'])) : null;
    $direccion = isset($_POST['direccion']) ? htmlspecialchars(trim($_POST['direccion'])) : null;
    $producto_bebida = isset($_POST['productos_bebida']) ? htmlspecialchars(trim($_POST['productos_bebida'])) : null;
    $producto_comida = isset($_POST['productos_comida']) ? htmlspecialchars(trim($_POST['productos_comida'])) : null;
    $productos_extra = isset($_POST['productos_extra']) ? htmlspecialchars(trim($_POST['productos_extra'])) : null;
    $cantidad = isset($_POST['cantidad']) && is_numeric($_POST['cantidad']) ? (int) $_POST['cantidad'] : null;

    if ($nombre && $email && $telefono && $direccion && $producto_bebida && $producto_comida && $productos_extra && $cantidad) {
        $stmt = $conn->prepare("INSERT INTO pedidos (nombre, email, telefono, direccion, producto_bebida, producto_comida, productos_extra, cantidad) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssi", $nombre, $email, $telefono, $direccion, $producto_bebida, $producto_comida, $productos_extra, $cantidad);

        if ($stmt->execute()) {
            echo "Pedido registrado con éxito";
        } else {
            throw new Exception("Error al registrar el pedido: " . $stmt->error);
        }
        $stmt->close();
    } else {
        throw new Exception("Error: Todos los campos son obligatorios y deben estar correctamente formateados.");
    }
} catch (Exception $e) {
    // Registrar error y mostrar mensaje genérico
    error_log($e->getMessage());
    echo "Ocurrió un problema al procesar el pedido. Por favor, inténtalo nuevamente.";
} finally {
    $conn->close();
}
?>
