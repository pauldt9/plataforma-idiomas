<?php
session_start();
$page_title = "Nivel";
$header_class = "main-header delete-name";

require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../models/PlanEstudio.php";

$plan = new PlanEstudio($pdo);

function generarPlanConIA($idioma, $nivel, $motivo) {
    set_time_limit(300); 

    $url = 'http://10.0.2.2:11434/api/generate';

    $prompt = "
    ACTUA COMO: Experto en educación de idiomas.
    TAREA: Crear un JSON con un plan de estudio de EXACTAMENTE 7 días.
    IDIOMA: $idioma.
    NIVEL: $nivel.
    
    REGLAS CRÍTICAS:
    1. Debes generar 7 objetos dentro del array 'dias'. NO MENOS.
    2. Usa JSON puro. Clave raiz: 'dias'.
    3. Claves internas: 'dia' (numero), 'tema' (string), 'actividades' (array string).
    4. Sé muy breve en las actividades para ahorrar tiempo.

    EJEMPLO DE SALIDA:
    {
      \"dias\": [
        {\"dia\": 1, \"tema\": \"Intro\", \"actividades\": [\"Actividad 1\"]},
        {\"dia\": 2, \"tema\": \"Saludos\", \"actividades\": [\"Actividad 1\"]},
        {\"dia\": 3, \"tema\": \"Familia\", \"actividades\": [\"Actividad 1\"]},
        {\"dia\": 4, \"tema\": \"Comida\", \"actividades\": [\"Actividad 1\"]},
        {\"dia\": 5, \"tema\": \"Viajes\", \"actividades\": [\"Actividad 1\"]},
        {\"dia\": 6, \"tema\": \"Hobby\", \"actividades\": [\"Actividad 1\"]},
        {\"dia\": 7, \"tema\": \"Repaso\", \"actividades\": [\"Test\"]}
      ]
    }
    ";

    $data = [
        "model" => "deepseek-coder", 
        "prompt" => $prompt,
        "stream" => false,        
        "format" => "json",
        "options" => [
            "temperature" => 0.1 
        ]
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 180);

    $response = curl_exec($ch);
    $error = curl_errno($ch);
    curl_close($ch);

    $jsonValido = null;

    if (!$error) {
        $decoded = json_decode($response, true);
        $rawJson = $decoded['response'] ?? '';
        $rawJson = preg_replace('/```json|```/', '', $rawJson);
        $jsonValido = json_decode($rawJson, true);
    }

    if ($error || !$jsonValido || !isset($jsonValido['dias']) || count($jsonValido['dias']) < 3) {
        
        return json_encode([
            "dias" => [
                ["dia" => 1, "tema" => "Fundamentos", "actividades" => ["Alfabeto y Sonidos", "Saludos básicos"]],
                ["dia" => 2, "tema" => "Presentación", "actividades" => ["Verbo Ser/Estar", "Decir mi nombre"]],
                ["dia" => 3, "tema" => "Números y Hora", "actividades" => ["Contar 1-20", "¿Qué hora es?"]],
                ["dia" => 4, "tema" => "La Familia", "actividades" => ["Miembros de la familia", "Posesivos"]],
                ["dia" => 5, "tema" => "Comida y Bebida", "actividades" => ["Vocabulario restaurante", "Me gusta/No me gusta"]],
                ["dia" => 6, "tema" => "La Ciudad", "actividades" => ["Lugares comunes", "Direcciones básicas"]],
                ["dia" => 7, "tema" => "Repaso Semanal", "actividades" => ["Quiz general", "Práctica oral"]]
            ]
        ]);
    }

    return $jsonValido; 
}

if (isset($_POST["idioma"])) $_SESSION["idioma"] = $_POST["idioma"];
if (isset($_POST["motivo"])) $_SESSION["motivo"] = $_POST["motivo"];

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["nivel"])) {

    $idioma = $_SESSION["idioma"] ?? null;
    $motivo = $_SESSION["motivo"] ?? null;
    $nivel = $_POST["nivel"] ?? null;
    $usuario_id = $_SESSION["user_id"] ?? 1; 

    if ($idioma && $motivo && $nivel) {
        $resultado = generarPlanConIA($idioma, $nivel, $motivo);
        $contenido_json = is_array($resultado) ? json_encode($resultado) : $resultado;
        
        $plan->create($usuario_id, $idioma, $nivel, $motivo, $contenido_json);

        unset($_SESSION["idioma"]);
        unset($_SESSION["motivo"]);

        header("Location: courseProgression.php");
        exit;
    }
}

include "../partials/header.php";
?>

<main class="container">
    <h2 class="instruction">¿Cuál es tu <span>Nivel</span>?</h2>
    <p class="tellUs">Prepararemos el mejor curso adecuado a tus conocimientos</p>
    <form action="" method="POST" class="buttons">
        <button type="submit" name="nivel" value="Principiante" class="btn-principiante">
            <img src="/proyecto/plataforma-idiomas/public/assets/Images/principiante.png">
            <div><strong>Principiante</strong><small>Soy nuevo con el idioma o conozco lo básico</small></div>
        </button>
        <button type="submit" name="nivel" value="Intermedio" class="btn-intermedio">
            <img src="/proyecto/plataforma-idiomas/public/assets/Images/intermedio.png">
            <div><strong>Intermedio</strong><small>Puedo desenvolverme en conversaciones simples</small></div>
        </button>
    </form>
</main>
<?php include "../partials/footer.php"; ?>