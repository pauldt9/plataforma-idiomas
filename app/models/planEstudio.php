<?php

class PlanEstudio {

    private $pdo;

    public function __construct($pdo){
        $this->pdo = $pdo;
    }

 
    public function exists($usuario_id){
        $stmt = $this->pdo->prepare("SELECT id FROM planes_estudio WHERE usuario_id = ?");
        $stmt->execute([$usuario_id]);
        return $stmt->fetch();
    }


    public function create($usuario_id, $idioma, $nivel, $objetivo){
        $stmt = $this->pdo->prepare("
            INSERT INTO planes_estudio (usuario_id, idioma, nivel, objetivo)
            VALUES (?, ?, ?, ?)
        ");
        return $stmt->execute([$usuario_id, $idioma, $nivel, $objetivo]);
    }
}
