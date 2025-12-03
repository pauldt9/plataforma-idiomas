<?php

require_once __DIR__ . '/../models/User.php';

class AuthController {

    private $user;

    public function __construct($pdo){
        $this->pdo = $pdo; 
        $this->user = new User($pdo);

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
}

    public function register(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $nombre = $_POST["nombre"];
            $email = $_POST["email"];
            $password = $_POST["password"];

            $this->user->register($nombre, $email, $password);

   
            header("Location: ../views/login.php?registered=1");
            exit;
        }
    }


    public function login(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST["email"];
            $password = $_POST["password"];

            $user = $this->user->login($email, $password);

            if ($user) {
                $_SESSION["user_id"] = $user["id"];
                $_SESSION["nombre"] = $user["nombre"];

                require_once __DIR__ . "/../models/planEstudio.php";
                $plan = new PlanEstudio($this->pdo);

                
                if (!$plan->exists($user["id"])) {
                    header("Location: ../views/languageSelection.php");
                    exit;
                }

                header("Location: ../views/courseProgression.php");
                exit;
            }

            return "Credenciales incorrectas";
        }
    }

    public function logout(){
        session_destroy();

        header("Location: ../views/home.php");
        exit;
    }

    public function rePassword() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $email = $_POST["email"];
        $newPass = $_POST["new_password"];

        $user = $this->user->getByEmail($email);

        if (!$user) {
            return "El correo no está registrado";
        }


        $hashed = password_hash($newPass, PASSWORD_DEFAULT);

        $this->user->updatePassword($email, $hashed);

        return "La contraseña ha sido actualizada correctamente.";
    }
}


}
