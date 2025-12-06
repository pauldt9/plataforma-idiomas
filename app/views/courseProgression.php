<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$page_title = "Progreso del Curso";
require_once __DIR__ . "/../config/database.php"; 
include "../partials/header-logged.php";

$user_id = $_SESSION["user_id"];
$stmt = $pdo->prepare("SELECT * FROM planes_estudio WHERE usuario_id = ? ORDER BY id DESC LIMIT 1");
$stmt->execute([$user_id]);
$plan = $stmt->fetch(PDO::FETCH_ASSOC);

$dias = [];
$idioma = "Desconocido";
$nivel = "Principiante";
$motivo = "General";
$progreso_actual = 0; 

if ($plan) {
    $idioma = htmlspecialchars($plan['idioma']);
    $nivel = htmlspecialchars($plan['nivel']);
    $motivo = htmlspecialchars($plan['motivo']);
    $progreso_actual = (int)$plan['progreso'];
    
    $json_content = $plan['contenido_json'];
    $json_clean = preg_replace('/```json|```/', '', $json_content); 
    
    $start = strpos($json_clean, '[');
    $end = strrpos($json_clean, ']');
    if ($start !== false && $end !== false) {
        $json_clean = substr($json_clean, $start, $end - $start + 1);
    }

    $raw_data = json_decode($json_clean, true);

    $lista_cruda = [];
    if (is_array($raw_data)) {
        if (isset($raw_data['planEstudios'])) $lista_cruda = $raw_data['planEstudios'];
        elseif (isset($raw_data['dias'])) $lista_cruda = $raw_data['dias'];
        elseif (isset($raw_data['plan'])) $lista_cruda = $raw_data['plan'];
        elseif (isset($raw_data['Days'])) $lista_cruda = $raw_data['Days'];
        else $lista_cruda = $raw_data; 
    }

    if (is_array($lista_cruda)) {
        foreach ($lista_cruda as $item) {
            $dia_val  = $item['dia'] ?? $item['day'] ?? $item['Day'] ?? 0;
            $tema_val = $item['tema'] ?? $item['topic'] ?? $item['Topic'] ?? 'General';
            
            if ($tema_val === 'General' && empty($item)) continue;

            $dias[] = [
                'dia' => $dia_val,
                'tema' => $tema_val,
                'actividades' => $item['actividades'] ?? $item['activities'] ?? $item['Activities'] ?? []
            ];
        }
    }
    
    if (empty($dias)) $dias = [];
}

$total_dias = count($dias);
$porcentaje = 0;
if ($total_dias > 0) {
    $porcentaje = ($progreso_actual / $total_dias) * 100;
}
?>

<div class="course-page container">
    <main class="course-main">

        <div class="course-title">
            <h2 class="main-title">Curso de <span class="highlight"><?= ucfirst($idioma) ?></span></h2>
            <div class="course-level">Nivel <span><?= ucfirst($nivel) ?></span></div>
        </div>

        <section class="course-card">
            <div class="progress-label">Tu Plan Personalizado (<?= $total_dias ?> Días)</div>
            
            <div class="progress-row">
                <div class="progress-track-wrap">
                    <div class="progress-track" role="progressbar">
                        <div class="progress-fill" style="width: <?= $porcentaje ?>%"></div>
                    </div>
                </div>
                <div class="progress-percent"><?= $progreso_actual ?>/<?= $total_dias ?></div>
            </div>

            <div class="steps-row">
                <div class="steps">
                    <?php if (empty($dias)): ?>
                        <div style="text-align:center; padding:20px;">
                            <p>Hubo un problema cargando tu plan. Intenta generar uno nuevo.</p>
                            <a href="languageSelection.php" class="btn small-submit-btn">Nuevo Plan</a>
                        </div>
                    <?php else: ?>

                        <?php foreach ($dias as $index => $dia): ?>
                            <?php 
                                $numeroDia = $index + 1;
                                $tema = is_array($dia) ? ($dia['tema'] ?? "Día $numeroDia") : "Día $numeroDia";
                                $imgIndex = ($index % 7) + 1; 

                                $estadoClase = "";
                                $linkHabilitado = false;

                                if ($index < $progreso_actual) {
                                    $estadoClase = "completed";
                                    $linkHabilitado = false; 
                                } elseif ($index == $progreso_actual) {
                                    $estadoClase = "active";
                                    $linkHabilitado = true;
                                } else {
                                    $estadoClase = ""; 
                                    $linkHabilitado = false;
                                }
                            ?>

                            <div class="step <?= $estadoClase ?>" style="margin-bottom: 30px;"> 
                                
                                <?php if ($linkHabilitado): ?>
                                    <a href="exercise.php?tema=<?= urlencode($tema) ?>&idioma=<?= urlencode($idioma) ?>&nivel=<?= urlencode($nivel) ?>&motivo=<?= urlencode($motivo) ?>" 
                                       class="avatar-wrap" title="¡A estudiar!">
                                        <img src="../../public/assets/Images/step<?= $imgIndex ?>.png" alt="Día <?= $numeroDia ?>">
                                    </a>
                                <?php else: ?>
                                    <div class="avatar-wrap" style="<?= $index > $progreso_actual ? 'filter: grayscale(100%); opacity: 0.6;' : '' ?>">
                                        <img src="../../public/assets/Images/step<?= $imgIndex ?>.png" alt="Día <?= $numeroDia ?>">
                                    </div>
                                <?php endif; ?>
                                
                                <div class="check"><i class="fa-solid fa-check"></i></div>

                                <p style="font-size: 14px; text-align: center; margin-top: 8px; font-weight:bold; color:#555;">
                                    Día <?= $numeroDia ?>
                                </p>
                                <p style="font-size: 11px; text-align: center; color:#888;">
                                    <?= htmlspecialchars(substr($tema, 0, 15)) ?>...
                                </p>
                            </div>

                            <?php if ($index < $total_dias - 1): ?>
                                <div class="connector <?= ($index < $progreso_actual) ? 'completed' : '' ?>"></div>
                            <?php endif; ?>

                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </main>
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<?php include "../partials/footer.php"; ?>