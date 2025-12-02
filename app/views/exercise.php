<?php
$page_title = "Ejercicio";
include "../partials/header.php";   // Carga <html>, <head>, y <body>
?>

<div class="exercise-page container">

    <!-- Header especial del ejercicio -->
    <header class="top-bar-exercise" style="width: 100%;">
        <h1 style="font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">X</h1>

        <div class="progress-track-wrap">
            <div class="progress-track-dark" role="progressbar">
                <div class="progress-fill-blue" style="width:7%"></div>
            </div>
        </div>
    </header>

    <!-- Contenido principal -->
    <main class="exercise-main">

        <div class="exercise-title">
            <h2 class="main-title">Escoge la opción correcta</h2>
        </div>

        <div class="exercise-instruction">
            The nurse told me that the clinic ____ open today.
        </div>

        <div class="exercise-card">
            <div class="options">
                <div class="option-button">was</div>
                <div class="option-button">is</div>
                <div class="option-button">were</div>
            </div>
        </div>

        <div class="exercise-footer">
            <div class="check-button">COMPROBAR</div>
        </div>

    </main>

</div>

<?php include "../partials/footer.php"; ?>
