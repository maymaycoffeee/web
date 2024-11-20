<?php

$host = 'localhost';
$usuario = 'root'; // Nombre de usuario de MySQL
$contraseña = ''; // Contraseña de MySQL (si la tienes, ingrésala aquí)
$base_datos = 'usuariosDB';

$conn = new mysqli($host, $usuario, $contraseña, $base_datos);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Consultar la base de datos para obtener los datos del usuario
    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();
        // Verificar si la contraseña es correcta
        if (password_verify($password, $usuario['password'])) {
            // Iniciar sesión, puedes establecer variables de sesión aquí
            session_start();
            $_SESSION['user_id'] = $usuario['id'];
            $_SESSION['user_name'] = $usuario['nombre'];
            header('Location: dashboard.php'); // Redirigir a una página segura
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "No se encontró el usuario.";
    }

    $stmt->close();
    $conn->close();
}
?>
