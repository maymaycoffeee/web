<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Configuración de la base de datos
    $servername = "localhost"; // O cambiar según tu entorno
    $username = "root"; // Usuario predeterminado en XAMPP
    $password = ""; // Contraseña predeterminada para root en XAMPP
    $dbname = "usuarios_db"; // Nombre de la base de datos creada

    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Error en la conexión: " . $conn->connect_error);
    }

    // Obtener y sanitizar los datos del formulario
    $nombre = htmlspecialchars(trim($_POST['nombre']));
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $password = trim($_POST['password']);

    if (!$email) {
        die("Correo electrónico inválido.");
    }

    // Encriptar la contraseña
    $password_hashed = password_hash($password, PASSWORD_DEFAULT);

    // Preparar la consulta para insertar los datos
    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)");
    if (!$stmt) {
        die("Error al preparar la consulta: " . $conn->error);
    }
    $stmt->bind_param("sss", $nombre, $email, $password_hashed);

    // Ejecutar la consulta e insertar los datos
    if ($stmt->execute()) {
        echo "Usuario registrado exitosamente!";
    } else {
        echo "Error al registrar el usuario: " . $stmt->error;
    }

    // Cerrar la declaración preparada y la conexión
    $stmt->close();
    $conn->close();
}
?>
