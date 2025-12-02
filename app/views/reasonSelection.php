<?php
$page_title = "Motivo";
$header_class = "main-header mobile-app-name delete-name";
include "../partials/header.php";
?>
<main class="container">
    <h2 class="instruction">¿Cuál es tu <span>Motivo</span>?</h2>
    <p class="tellUs">Cuéntanos qué te motivó a aprender este idioma</p>

    <form action="levelSelection.php" method="get" class="buttons">
        <button class="btn-negocio">
            <img src="/proyecto/plataforma-idiomas/public/assets/Images/maletin.png"> Negocios
        </button>

        <button class="btn-viaje">
            <img src="/proyecto/plataforma-idiomas/public/assets/Images/viajes-por-todo-el-mundo.png"> Viajar por el mundo
        </button>

        <button class="btn-estudio">
            <img src="/proyecto/plataforma-idiomas/public/assets/Images/gorra.png"> Impulsar mis estudios
        </button>

        <button class="btn-conectar">
            <img src="/proyecto/plataforma-idiomas/public/assets/Images/enlace.png"> Conectar con más personas
        </button>
    </form>
</main>
<?php include "../partials/footer.php"; ?>
