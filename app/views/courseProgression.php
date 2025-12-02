<?php
$page_title = "Progreso del Curso";
$header_class = "top-bar"; 
include "../partials/header-logged.php";
?>

<div class="course-page container">



    <!-- Contenido principal -->
    <main class="course-main">

        <div class="course-title">
            <h2 class="main-title">Curso de <span class="highlight">ingles</span></h2>
            <div class="course-level">Nivel <span>principiante</span></div>
        </div>

        <!-- Card con progreso -->
        <section class="course-card" aria-label="Progreso del curso">

            <div class="progress-label">Progreso del curso</div>

            <div class="progress-row">

                <div class="progress-track-wrap">
                    <div class="progress-track" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="7">
                        <div class="progress-fill" style="width:7%"></div>
                    </div>
                </div>

                <div class="progress-percent">7%</div>
            </div>

            <!-- Steps / Niveles representados por círculos con avatar -->
            <div class="steps-row" aria-hidden="false">
                <div class="steps">

                    <!-- Paso 1 (completado) -->
                    <div class="step completed" aria-label="Módulo 1 completado">
                        <div class="avatar-wrap">
                            <img src="/proyecto/plataforma-idiomas/public/assets/Images/step1.png" alt="Módulo 1">
                            <span class="check">✓</span>
                        </div>
                    </div>

                    <div class="connector"></div>

                    <!-- Paso 2 (activo / siguiente) -->
                    <div class="step active" aria-label="Módulo 2 en curso">
                        <a href="exercise.php" class="avatar-wrap">
                            <img src="/proyecto/plataforma-idiomas/public/assets/Images/step2.png" alt="Módulo 2">
                        </a>
                    </div>

                    <div class="connector"></div>

                    <!-- Paso 3 -->
                    <div class="step" aria-label="Módulo 3">
                        <div class="avatar-wrap">
                            <img src="/proyecto/plataforma-idiomas/public/assets/Images/step3.png" alt="Módulo 3">
                        </div>
                    </div>

                    <div class="connector"></div>

                    <!-- Paso 4 -->
                    <div class="step" aria-label="Módulo 4">
                        <div class="avatar-wrap">
                            <img src="/proyecto/plataforma-idiomas/public/assets/Images/step4.png" alt="Módulo 4">
                        </div>
                    </div>

                    <div class="connector"></div>

                    <!-- Paso 5 -->
                    <div class="step" aria-label="Módulo 5">
                        <div class="avatar-wrap">
                            <img src="/proyecto/plataforma-idiomas/public/assets/Images/step5.png" alt="Módulo 5">
                        </div>
                    </div>

                    <div class="connector"></div>

                    <!-- Paso 6 -->
                    <div class="step" aria-label="Módulo 6">
                        <div class="avatar-wrap">
                            <img src="/proyecto/plataforma-idiomas/public/assets/Images/step6.png" alt="Módulo 6">
                        </div>
                    </div>

                    <div class="connector"></div>

                    <!-- Paso 7 -->
                    <div class="step" aria-label="Módulo 7">
                        <div class="avatar-wrap">
                            <img src="/proyecto/plataforma-idiomas/public/assets/Images/step7.png" alt="Módulo 7">
                        </div>
                    </div>

                </div>
            </div>

        </section>

    </main>

</div>

<?php include "../partials/footer.php"; ?>
