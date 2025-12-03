<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$page_title = "Recuperar contraseña";

require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../controllers/AuthController.php";

$auth = new AuthController($pdo);
$message = $auth->rePassword();
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

        <h1 class="card-title">Restablecer contraseña</h1>

        <?php if (!empty($message)): ?>
            <div style="color:red; text-align:center; margin-bottom:10px;">
                <?= $message ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST">
            <input type="text" name="email" class="mail-input" placeholder="Correo registrado" required>
            <input type="password" name="new_password" class="pass-input" placeholder="Nueva contraseña" required>

            <button type="submit" class="btn small-submit-btn space">CONFIRMAR</button>
        </form>

        <p class="register-prompt">¿Ya recordaste la contraseña?</p>
        <a href="login.php" class="btn small-reg-btn">INICIAR SESIÓN</a>
    </div>
</main>

</body>
</html>
