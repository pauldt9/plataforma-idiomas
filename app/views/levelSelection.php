<?php
session_start();

$page_title = "Nivel";
$header_class = "main-header delete-name";

require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../models/PlanEstudio.php";

$plan = new PlanEstudio($pdo);

// Recuperar datos previos desde POST o mantener sesión
if (isset($_POST["idioma"])) {
    $_SESSION["idioma"] = $_POST["idioma"];
}
if (isset($_POST["motivo"])) {
    $_SESSION["motivo"] = $_POST["motivo"];
}

// CUANDO SE SELECCIONA EL NIVEL

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["nivel"])) {

    $idioma = $_SESSION["idioma"] ?? null;
    $motivo = $_SESSION["motivo"] ?? null;
    $nivel = $_POST["nivel"] ?? null;
    $usuario_id = $_SESSION["user_id"] ?? null;

    if ($idioma && $motivo && $nivel && $usuario_id) {

        // Crear el plan de estudio
        $plan->create($usuario_id, $idioma, $nivel, $motivo);

        // Limpieza
        unset($_SESSION["idioma"]);
        unset($_SESSION["motivo"]);

        // Redirigir
        header("Location: courseProgression.php");
        exit;
    }
}

include "../partials/header.php";
?>

<main class="container">
    <h2 class="instruction">¿Cuál es tu <span>Nivel</span>?</h2>
    <p class="tellUs">Prepararemos el mejor curso adecuado a tus conocimientos</p>

    <!-- FORMULARIO REAL -->
    <form action="" method="POST" class="buttons">

        <button type="submit" name="nivel" value="Principiante" class="btn-principiante">
            <img src="/proyecto/plataforma-idiomas/public/assets/Images/principiante.png">
            <div>
                <strong>Principiante</strong>
                <small>Soy nuevo con el idioma o conozco lo básico</small>
            </div>
        </button>

        <button type="submit" name="nivel" value="Intermedio" class="btn-intermedio">
            <img src="/proyecto/plataforma-idiomas/public/assets/Images/intermedio.png">
            <div>
                <strong>Intermedio</strong>
                <small>Puedo desenvolverme en conversaciones simples</small>
            </div>
        </button>
    </form>
</main>

<?php include "../partials/footer.php"; ?>
