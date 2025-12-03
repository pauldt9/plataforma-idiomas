<?php

class User {

    private $pdo;

    public function __construct($pdo){
        $this->pdo = $pdo;
    }

    public function register($nombre, $email, $password){
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO usuarios (nombre, email, password_hash) VALUES (?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([$nombre, $email, $hash]);
    }

    public function login($email, $password){
        $sql = "SELECT * FROM usuarios WHERE email = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$email]);

        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            return $user;
        }

        return false;
    }

    public function getByEmail($email){
        $sql = "SELECT * FROM usuarios WHERE email = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$email]);

        return $stmt->fetch();
    }


    public function generateResetToken($email){
        $token = bin2hex(random_bytes(16));
        
       
        return $token;
    }

    public function updatePassword($email, $newHash) {
    $stmt = $this->pdo->prepare("UPDATE usuarios SET password_hash = ? WHERE email = ?");
    return $stmt->execute([$newHash, $email]);
}

}
