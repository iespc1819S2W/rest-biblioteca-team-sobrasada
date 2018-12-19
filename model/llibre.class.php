<?php

$base = __DIR__ . '/..';
require_once("$base/lib/resposta.class.php");
require_once("$base/lib/database.class.php");

class Llibre {

    private $conn;       //connexió a la base de dades (PDO)
    private $resposta;   // resposta

    public function __CONSTRUCT() {
        $this->conn = Database::getInstance()->getConnection();
        $this->resposta = new Resposta();
    }

    public function getAll($orderby = "id_llibre") {
        try {
            $result = array();
            $stm = $this->conn->prepare("SELECT id_aut,nom_aut,fk_nacionalitat FROM autors ORDER BY $orderby");
            $stm->execute();
            $tuples = $stm->fetchAll();
            $this->resposta->setDades($tuples);    // array de tuples
            $this->resposta->setCorrecta(true);       // La resposta es correcta        
            return $this->resposta;
        } catch (Exception $e) {   // hi ha un error posam la resposta a fals i tornam missatge d'error
            $this->resposta->setCorrecta(false, $e->getMessage());
            return $this->resposta;
        }
    }

    public function get($id) {
        try{
            $sql = "SELECT * FROM LLIBRES where ID_LLIB = $id";
            $stm=$this->conn->prepare($sql);
            $stm->execute();
            $row=$stm->fetch();
            $this->resposta->SetDades($row);
            $this->resposta->setCorrecta(true);
            return $this->resposta;

        }catch(Exception $e){
            $this->resposta->setCorrecta(false, "Error get ID: ".$e->getMessage());
            return $this->resposta;
        }
    }

    public function insert($data) {
        try {
            $sql = "SELECT max(id_aut) as N from autors";
            $stm = $this->conn->prepare($sql);
            $stm->execute();
            $row = $stm->fetch();
            $id_aut = $row["N"] + 1;
            $nom_aut = $data['nom_aut'];
            $fk_nacionalitat = $data['fk_nacionalitat'];

            $sql = "INSERT INTO autors
                            (id_aut,nom_aut,fk_nacionalitat)
                            VALUES (:id_aut,:nom_aut,:fk_nacionalitat)";

            $stm = $this->conn->prepare($sql);
            $stm->bindValue(':id_aut', $id_aut);
            $stm->bindValue(':nom_aut', $nom_aut);
            $stm->bindValue(':fk_nacionalitat', !empty($fk_nacionalitat) ? $fk_nacionalitat : NULL, PDO::PARAM_STR);
            $stm->execute();

            $this->resposta->setCorrecta(true);
            return $this->resposta;
        } catch (Exception $e) {
            $this->resposta->setCorrecta(false, "Error insertant: " . $e->getMessage());
            return $this->resposta;
        }
    }

    public function update($data) {
        // TODO
    }

    public function delete($id) {
        // TODO
    }

    public function filtra($where, $orderby, $offset, $count) {
        // TODO
    }

}
