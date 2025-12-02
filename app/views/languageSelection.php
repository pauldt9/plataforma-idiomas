<?php
$page_title = "Seleccion de Idioma";
$header_class = "main-header mobile-app-name delete-name";
include "../partials/header.php";
?>
<main class="container">
    <h2 class="instruction">¿Qué <span>idioma</span> deseas aprender?</h2>
    
    <form action="reasonSelection.php" method="get" class="buttons">
        <button class="btn-ingles">
            <img src="/proyecto/plataforma-idiomas/public/assets/Images/icons8-circular-de-gran-bretaña-100.png">
            Ingles
        </button>

        <button class="btn-frances">
            <img src="/proyecto/plataforma-idiomas/public/assets/Images/icons8-bandera-francesa-100.png">
            Frances
        </button>

        <button class="btn-español">
            <img src="/proyecto/plataforma-idiomas/public/assets/Images/icons8-circular-mexico-100.png">
            Español
        </button>

        <p class="reminder">Recuerda que puedes aprender un nuevo idioma en la pantalla de inicio</p>
    </form>
</main>
<?php include "../partials/footer.php"; ?>
