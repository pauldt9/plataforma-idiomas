<?php
$page_title = "Iniciar Sesión";
$header_class = "main-header mobile-app-name";
include "../partials/header.php";
?>
<main class="main-user-form">
    <div class="gradient-card">
        <h1 class="card-title">Iniciar sesión</h1>
        
        <form action="languageSelection.php" method="get">
            <input type="text" class="mail-input" placeholder="Correo">
            <input type="password" class="pass-input" placeholder="Contraseña">
            <a href="#" class="forgot-link">¿Olvidaste tu contraseña?</a>
            <button type="submit" class="btn small-submit-btn">ENTRAR</button>
        </form>

        <p class="register-prompt">¿Eres nuevo?</p>
        <a href="register.php" class="btn small-reg-btn">REGISTRATE</a>
    </div>
</main>
<?php include "../partials/footer.php"; ?>
