<?php

$base = __DIR__ . '/..';
require_once("$base/lib/resposta.class.php");
require_once("$base/lib/database.class.php");

class LliAut {

    private $conn;       //connexió a la base de dades (PDO)
    private $resposta;   // resposta

    public function __CONSTRUCT() {
        $this->conn = Database::getInstance()->getConnection();
        $this->resposta = new Resposta();
    }

    public function insert($data) {
        try {
            $id_llibre = $data["id_llibre"];
            $id_autor = $data["id_autor"];
            $sql = "INSERT INTO `LLI_AUT`(`FK_IDLLIB`, `FK_IDAUT`, `FK_ROLAUT`) VALUES (:fk_llib,:fkaut,:rol)";

            $stm = $this->conn->prepare($sql);
            $stm->bindValue(':fk_llib', $id_llibre, PDO::PARAM_INT);
            $stm->bindValue(':fkaut', $id_autor, PDO::PARAM_INT);
            $stm->bindValue(':rol', !empty($data["rol"]) ? $data["rol"] : NULL, PDO::PARAM_STR);
            $stm->execute();

            $this->resposta->setCorrecta(true);
            return $this->resposta;
        } catch (Exception $e) {
            $this->resposta->setCorrecta(false, "Error insertant: " . $e->getMessage());
            return $this->resposta;
        }
    }
    
    public function delete($data) {
        try {
            $sql = "DELETE FROM `LLI_AUT` WHERE `FK_IDLLIB`= :fk_llib AND `FK_IDAUT`= :fk_aut";
            
            $stm = $this->conn->prepare($sql);
            $stm->bindValue(':fk_llib', $data["id_llibre"]);
            $stm->bindValue(':fk_aut', $data["id_autor"]);
            $stm->execute();
            $this->resposta->setCorrecta(true);
            return $this->resposta;
        } catch (Exception $ex) {
            $this->resposta->setCorrecta(false, "Error eliminant: " . $e->getMessage());
            return $this->resposta;
        }
    }
}