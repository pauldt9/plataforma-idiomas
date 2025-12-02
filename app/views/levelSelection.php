<?php
$page_title = "Nivel";
$header_class = "main-header delete-name";
include "../partials/header.php";
?>
<main class="container">
    <h2 class="instruction">¿Cuál es tu <span>Nivel</span>?</h2>
    <p class="tellUs">Prepararemos el mejor curso adecuado a tus conocimientos</p>

    <div class="buttons">
        <button class="btn-principiante">
            <img src="/proyecto/plataforma-idiomas/public/assets/Images/principiante.png">
            <div>
                <strong>Principiante</strong>
                <small>Soy nuevo con el idioma o conozco lo básico</small>
            </div>
        </button>

        <button class="btn-intermedio">
            <img src="/proyecto/plataforma-idiomas/public/assets/Images/intermedio.png">
            <div>
                <strong>Intermedio</strong>
                <small>Puedo desenvolverme en conversaciones simples</small>
            </div>
        </button>
    </div>

    <form action="courseProgression.php" method="get" class="generate">
        <button class="btn-generar">GENERAR MI PLAN</button>
    </form>
</main>
<?php include "../partials/footer.php"; ?>
