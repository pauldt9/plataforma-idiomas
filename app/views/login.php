<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$page_title = "Iniciar Sesión";
$header_class = "main-header mobile-app-name";


require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../controllers/AuthController.php";

$auth = new AuthController($pdo);
$error = $auth->login();


include "../partials/header.php";
?>

<main class="main-user-form">
    <div class="gradient-card">

        <h1 class="card-title">Iniciar sesión</h1>

  
        <?php if (!empty($error)): ?>
            <div style="color:red; text-align:center; margin-bottom:10px;">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST">
            <input type="text" class="mail-input" name="email" placeholder="Correo" required>
            <input type="password" class="pass-input" name="password" placeholder="Contraseña" required>

            <a href="rePassword.php" class="forgot-link">¿Olvidaste tu contraseña?</a>

            <button type="submit" class="btn small-submit-btn">ENTRAR</button>
        </form>

        <p class="register-prompt">¿Eres nuevo?</p>
        <a href="register.php" class="btn small-reg-btn">REGISTRATE</a>
    </div>
</main>

<?php include "../partials/footer.php"; ?>
