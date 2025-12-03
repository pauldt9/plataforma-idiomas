<?php
session_start();

$page_title = "Motivo";
$header_class = "main-header mobile-app-name delete-name";
include "../partials/header.php";

// Guardar idioma desde languageSelection
if (isset($_POST["idioma"])) {
    $_SESSION["idioma"] = $_POST["idioma"];
}
?>

<main class="container">
    <h2 class="instruction">¿Cuál es tu <span>Motivo</span>?</h2>
    <p class="tellUs">Cuéntanos qué te motivó a aprender este idioma</p>

    <form action="levelSelection.php" method="POST" class="buttons">

        <button type="submit" name="motivo" value="negocios" class="btn-negocio">
            <img src="/proyecto/plataforma-idiomas/public/assets/Images/maletin.png"> Negocios
        </button>

        <button type="submit" name="motivo" value="viajes" class="btn-viaje">
            <img src="/proyecto/plataforma-idiomas/public/assets/Images/viajes-por-todo-el-mundo.png"> Viajar por el mundo
        </button>

        <button type="submit" name="motivo" value="estudios" class="btn-estudio">
            <img src="/proyecto/plataforma-idiomas/public/assets/Images/gorra.png"> Impulsar mis estudios
        </button>

        <button type="submit" name="motivo" value="conectar" class="btn-conectar">
            <img src="/proyecto/plataforma-idiomas/public/assets/Images/enlace.png"> Conectar con más personas
        </button>

    </form>
</main>
<?php include "../partials/footer.php"; ?>
