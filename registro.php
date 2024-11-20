<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

var_dump($_POST);

// Configuración de la conexión a la base de datos
$servername = "localhost"; // El servidor (normalmente 'localhost')
$username = "root"; // Cambia por tu usuario real de la base de datos
$password = ""; // Cambia por la contraseña real de tu usuario
$dbname = "nombre_base_datos"; // Cambia por el nombre correcto de tu base de datos

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = new mysqli($servername, $username, $password, $dbname);
    echo "Conexión exitosa a la base de datos.";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $password_input = isset($_POST['password']) ? $_POST['password'] : '';

        if (empty($nombre) || empty($email) || empty($password_input)) {
            throw new Exception("Todos los campos son obligatorios.");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("El formato del correo electrónico no es válido.");
        }

        if (strlen($nombre) < 3) {
            throw new Exception("El nombre debe tener al menos 3 caracteres.");
        }
        if (strlen($password_input) < 6) {
            throw new Exception("La contraseña debe tener al menos 6 caracteres.");
        }

        $password = password_hash($password_input, PASSWORD_BCRYPT);

        $stmt = $conn->prepare("INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nombre, $email, $password);

        if ($stmt->execute()) {
            echo "Registro exitoso. ¡Bienvenido, $nombre!";
        } else {
            echo "Error al guardar los datos: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Por favor, envíe los datos desde el formulario.";
    }
} catch (mysqli_sql_exception $e) {
    die("Error en la base de datos: " . $e->getMessage());
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
} finally {
    if (isset($conn) && $conn instanceof mysqli) {
        $conn->close();
    }
}

?>
