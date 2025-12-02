<?php
$page_title = $page_title ?? "Talkio";
$header_class = $header_class ?? "top-bar";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?></title>

    <link rel="stylesheet" href="http://localhost:8080/proyecto/plataforma-idiomas/public/assets/CSS/home.css">
</head>

<body>

<header class="<?= $header_class ?>" style="width:100%;">
    <h1 class="main-header">Talkio</h1>
    <div class="profile-icon" title="Mi perfil">
        <img src="/proyecto/plataforma-idiomas/public/assets/Images/pfp.png" alt="Usuario">
    </div>
</header>
