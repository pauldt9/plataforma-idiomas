<?php
$page_title = "Plataforma de Idiomas";
$header_class = "main-header";
include "../partials/header.php";
?>
<main class="hero-content">
    <div class="main-img">
        <img src="/proyecto/plataforma-idiomas/public/assets/Images/main image.jpg" alt="main image">
    </div>

    <section class="main-content">
        <div>
            <h1 class="main-title">
                Descubre una nueva forma de<br>aprender <span class="highlight">idiomas</span>
            </h1>
        </div>

        <div>
            <a href="/proyecto/plataforma-idiomas/app/views/register.php" class="btn register-btn">EMPEZAR</a>
            <br>
            <a href="/proyecto/plataforma-idiomas/app/views/login.php" class="btn login-btn">YA TENGO UNA CUENTA</a>
        </div>

        <div class="flags-container">
            <img src="/proyecto/plataforma-idiomas/public/assets/Images/icons8-circular-de-gran-bretaña-100.png" alt="english flag">
            <img src="/proyecto/plataforma-idiomas/public/assets/Images/icons8-bandera-francesa-100.png" alt="french flag">
            <img src="/proyecto/plataforma-idiomas/public/assets/Images/icons8-circular-mexico-100.png" alt="mexican flag">
        </div>
    </section>
</main>
<?php include "../partials/footer.php"; ?>
