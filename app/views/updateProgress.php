<?php
session_start();
require_once __DIR__ . "/../config/database.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION["user_id"];

$stmt = $pdo->prepare("SELECT id, progreso, contenido_json FROM planes_estudio WHERE usuario_id = ? ORDER BY id DESC LIMIT 1");
$stmt->execute([$user_id]);
$plan = $stmt->fetch(PDO::FETCH_ASSOC);

if ($plan) {
    $json_clean = preg_replace('/```json|```/', '', $plan['contenido_json']);
    $dias_array = json_decode($json_clean, true);
    
    if (isset($dias_array['planEstudios'])) $dias_array = $dias_array['planEstudios'];
    elseif (isset($dias_array['dias'])) $dias_array = $dias_array['dias'];
    elseif (isset($dias_array['plan'])) $dias_array = $dias_array['plan'];
    
    $total_dias = is_array($dias_array) ? count($dias_array) : 0;

    if ($plan['progreso'] < $total_dias) {
        $nuevo_progreso = $plan['progreso'] + 1;
        
        $update = $pdo->prepare("UPDATE planes_estudio SET progreso = ? WHERE id = ?");
        $update->execute([$nuevo_progreso, $plan['id']]);
    }
}

header("Location: courseProgression.php");
exit;