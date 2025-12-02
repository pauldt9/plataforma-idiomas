<?php

require 'php/db.php';

$mensaje = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!empty($nombre) && !empty($email) && !empty($password)) {

        $password_hash = password_hash($password, PASSWORD_DEFAULT);


        $sql = "INSERT INTO usuarios (nombre, email, password_hash) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        
        try {
            if ($stmt->execute([$nombre, $email, $password_hash])) {
                header("Location: login.php");
                exit();
            }
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $mensaje = "Este correo ya está registrado.";
            } else {
                $mensaje = "Error: " . $e->getMessage();
            }
        }
    } else {
        $mensaje = "Por favor completa todos los campos";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrate</title>
    <link rel="stylesheet" href="./CSS/home.css">
</head>
<body>
    <!--Encabezado-->
    <header class="main-header mobile-app-name">
        <h1>Talkio</h1>
    </header>
    <main class="main-user-form">
        <div class="gradient-card">
            <h1 class="card-title">Registrate</h1>

            <form action="languageSelection.html" method="POST">
                <input type="text" class="name-input" placeholder="Nombre">
                <input type="text" class="mail-input" placeholder="Correo">
                <input type="password" class="pass-input" placeholder="Contraseña">
                <button type="submit" class="btn small-submit-btn space">REGISTRARSE</button>
            </form>

            <p class="register-prompt">¿Ya tienes cuenta?</p>
            <a href="login.html" class="btn small-reg-btn">INICIA SESIÓN</a>
        </div>
    </main>
</body>
</html>