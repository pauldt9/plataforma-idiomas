<?php
session_start();
$page_title = "Ejercicio";

$tema = $_GET['tema'] ?? 'Vocabulario Básico';
$idioma = $_GET['idioma'] ?? 'Inglés';
$nivel = $_GET['nivel'] ?? 'Principiante';
$motivo = $_GET['motivo'] ?? 'General';

function generarEjercicioIA($idioma, $tema, $nivel, $motivo) {
    set_time_limit(120); 

    $url = 'http://10.0.2.2:11434/api/generate';
    $maxRetries = 2; 
    $intento = 0;

    $prompt = "
    ROLE: Language Teacher.
    TASK: Create 1 multiple-choice question for a student learning $idioma.
    TOPIC: $tema.
    LEVEL: $nivel (A1).
    INSTRUCTION LANGUAGE: Spanish.

    RULES:
    1. Output JSON ONLY.
    2. JSON KEYS: \"pregunta\", \"opciones\", \"indice_correcto\", \"explicacion\".
    3. Ensure the correct answer is actually correct for the target language.

    JSON FORMAT:
    {
        \"pregunta\": \"¿Cómo se dice '...' en $idioma?\",
        \"opciones\": [\"Bad Option\", \"Correct Option\", \"Bad Option\"],
        \"indice_correcto\": 1,
        \"explicacion\": \"Because...\"
    }
    ";

    do {
        $intento++;
        
        $data = [
            "model" => "deepseek-coder", 
            "prompt" => $prompt,
            "stream" => false,
            "format" => "json",
            "options" => ["temperature" => 0.1]
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 90); 

        $response = curl_exec($ch);
        $error = curl_errno($ch);
        curl_close($ch);

        if (!$error) {
            $jsonResponse = json_decode($response, true);
            $textoIA = $jsonResponse['response'] ?? '';
            $textoIA = preg_replace('/```json|```/', '', $textoIA);
            
            $datos = json_decode($textoIA, true);

            if ($datos) {
                if (isset($datos['question'])) $datos['pregunta'] = $datos['question'];
                if (isset($datos['options'])) $datos['opciones'] = $datos['options'];
                if (isset($datos['correct_index'])) $datos['indice_correcto'] = $datos['correct_index'];
                if (isset($datos['explanation'])) $datos['explicacion'] = $datos['explanation'];

                if (isset($datos['pregunta'], $datos['opciones'], $datos['indice_correcto'])) {
                    return $datos; 
                }
            }
        }
    } while ($intento < $maxRetries);

    $idiomaLower = strtolower($idioma);
    
    if (strpos($idiomaLower, 'ingles') !== false || strpos($idiomaLower, 'inglés') !== false) {
        return [
            "pregunta" => "¿Cómo se dice 'Gracias' en Inglés?",
            "opciones" => ["Please", "Hello", "Thank you"],
            "indice_correcto" => 2, 
            "explicacion" => "'Thank you' es la forma correcta de agradecer."
        ];
    } elseif (strpos($idiomaLower, 'frances') !== false || strpos($idiomaLower, 'francés') !== false) {
        return [
            "pregunta" => "¿Cómo se dice 'Buenos días' en Francés?",
            "opciones" => ["Bonjour", "Merci", "Au revoir"],
            "indice_correcto" => 0, 
            "explicacion" => "'Bonjour' se usa para saludar durante el día."
        ];
    } else {
        // Default general
        return [
            "pregunta" => "Selecciona la palabra correcta para 'Azul' en $idioma",
            "opciones" => ["Blue/Bleu", "Red/Rouge", "Green/Vert"],
            "indice_correcto" => 0,
            "explicacion" => "Es el color del cielo."
        ];
    }
}

$ejercicio = generarEjercicioIA($idioma, $tema, $nivel, $motivo);

include "../partials/header.php";   
?>

<div class="exercise-page container">
    <header class="top-bar-exercise" style="width: 100%;">
        <a href="courseProgression.php" style="color: #252525; text-decoration: none;">
            <i class="fa-solid fa-xmark" style="font-size: 2rem; cursor: pointer;"></i>
        </a>
        <div class="progress-track-wrap">
            <div class="progress-track-dark" role="progressbar">
                <div class="progress-fill-blue" style="width:33%"></div>
            </div>
        </div>
    </header>

    <main class="exercise-main">
        <div class="exercise-title">
            <h2 class="main-title">Lección: <?= htmlspecialchars($tema) ?></h2>
        </div>

        <div class="exercise-instruction" style="font-size: 1.5rem; font-weight: bold; text-align: center; margin: 30px 0;">
            <?= htmlspecialchars($ejercicio['pregunta']) ?>
        </div>

        <div class="exercise-card">
            <div class="options">
                <?php if (!empty($ejercicio['opciones']) && is_array($ejercicio['opciones'])): ?>
                    <?php foreach ($ejercicio['opciones'] as $index => $opcion): ?>
                        <div class="option-button" data-index="<?= $index ?>" onclick="seleccionar(this)">
                            <?= htmlspecialchars($opcion) ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <div id="feedback-area" style="display:none; margin-top: 20px; padding: 15px; border-radius: 10px; text-align: center;">
            <h3 id="feedback-title" style="margin: 0;"></h3>
            <p id="feedback-text" style="margin: 5px 0 0 0;">
                <?= htmlspecialchars($ejercicio['explicacion'] ?? '') ?>
            </p>
        </div>

        <div class="exercise-footer">
            <div class="check-button" id="btnComprobar" data-correcta="<?= $ejercicio['indice_correcto'] ?>">
                COMPROBAR
            </div>
        </div>
    </main>
</div>

<script>
    let seleccionUsuarioIndex = null;
    let respondido = false;

    function seleccionar(elemento) {
        if (respondido) return;
        document.querySelectorAll('.option-button').forEach(btn => {
            btn.style.backgroundColor = '#fff';
            btn.style.border = '2px solid #e5e5e5';
            btn.style.color = '#4b4b4b';
        });
        elemento.style.backgroundColor = '#ddf4ff';
        elemento.style.border = '2px solid #1cb0f6';
        elemento.style.color = '#1899d6';
        seleccionUsuarioIndex = elemento.getAttribute('data-index');
    }

    document.getElementById('btnComprobar').addEventListener('click', function() {
        if (seleccionUsuarioIndex === null || respondido) {
            if (respondido) window.location.href = 'updateProgress.php';
            return;
        }
        let correctaIndex = this.getAttribute('data-correcta');
        let feedbackArea = document.getElementById('feedback-area');
        let feedbackTitle = document.getElementById('feedback-title');
        
        respondido = true; 
        if (parseInt(seleccionUsuarioIndex) === parseInt(correctaIndex)) {
            feedbackArea.style.display = 'block';
            feedbackArea.style.backgroundColor = '#d7ffb8';
            feedbackArea.style.color = '#58a700';
            feedbackTitle.innerText = "¡Correcto!";
            this.innerText = "CONTINUAR";
            this.style.backgroundColor = '#58cc02';
        } else {
            feedbackArea.style.display = 'block';
            feedbackArea.style.backgroundColor = '#ffdfe0';
            feedbackArea.style.color = '#ea2b2b';
            feedbackTitle.innerText = "Incorrecto";
            this.innerText = "CONTINUAR";
            this.style.backgroundColor = '#ff4b4b';
        }
    });
</script>
<?php include "../partials/footer.php"; ?>