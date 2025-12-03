<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$page_title = "Registrate";


require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../controllers/AuthController.php";


$auth = new AuthController($pdo);
$errors = $auth->register();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?></title>

    <link rel="stylesheet" href="/proyecto/plataforma-idiomas/public/assets/CSS/home.css">
</head>

<body>

    <header class="main-header mobile-app-name">
        <h1>Talkio</h1>
    </header>

    <main class="main-user-form">
        <div class="gradient-card">
            
            <h1 class="card-title">Registrate</h1>

   
            <?php if (!empty($errors)): ?>
                <div style="color: red; text-align:center; margin-bottom: 10px;">
                    <?php foreach ($errors as $e): ?>
                        <p><?= $e ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form action="" method="POST">
                <input type="text" class="name-input" placeholder="Nombre" name="nombre" required>
                <input type="text" class="mail-input" placeholder="Correo" name="email" required>
                <input type="password" class="pass-input" placeholder="Contraseña" name="password" required>
                
                <button type="submit" class="btn small-submit-btn space">REGISTRARSE</button>
            </form>

            <p class="register-prompt">¿Ya tienes cuenta?</p>

            <a href="/proyecto/plataforma-idiomas/app/views/login.php" class="btn small-reg-btn">INICIA SESIÓN</a>
        </div>
    </main>

</body>
</html>
