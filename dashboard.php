<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    // Si el usuario no está logueado, redirigir al login
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido</title>
</head>
<body>
    <h1>Bienvenido, <?php echo $_SESSION['user_name']; ?></h1>
    <p>Has iniciado sesión correctamente.</p>
    <a href="logout.php">Cerrar sesión</a>
</body>
</html>
