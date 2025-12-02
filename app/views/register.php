<?php
$page_title = "Registrate";
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

           
            <form action="/proyecto/plataforma-idiomas/app/views/languageSelection.php" method="POST">
                <input type="text" class="name-input" placeholder="Nombre" required>
                <input type="text" class="mail-input" placeholder="Correo" required>
                <input type="password" class="pass-input" placeholder="Contraseña" required>
                
                <button type="submit" class="btn small-submit-btn space">REGISTRARSE</button>
            </form>

            <p class="register-prompt">¿Ya tienes cuenta?</p>

            
            <a href="/proyecto/plataforma-idiomas/app/views/login.php" class="btn small-reg-btn">INICIA SESIÓN</a>
        </div>
    </main>

</body>
</html>
