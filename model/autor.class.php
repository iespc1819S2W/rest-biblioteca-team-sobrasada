<?php

$base = __DIR__ . '/..';
require_once("$base/lib/resposta.class.php");
require_once("$base/lib/database.class.php");

class Autor {

    private $conn;       //connexió a la base de dades (PDO)
    private $resposta;   // resposta

    public function __CONSTRUCT() {
        $this->conn = Database::getInstance()->getConnection();
        $this->resposta = new Resposta();
    }

    public function getAll($orderby = "id_aut") {
        try {
            $result = array();
            $stm = $this->conn->prepare("SELECT id_aut,nom_aut,fk_nacionalitat FROM AUTORS ORDER BY $orderby");
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
        try {
            $result = array();
            $stm = $this->conn->prepare("SELECT id_aut,nom_aut,fk_nacionalitat FROM AUTORS WHERE ID_AUT = :id_aut ORDER BY id_aut");
            $stm->bindValue(':id_aut', $id);
            $stm->execute();
            $tuples = $stm->fetch();
            $this->resposta->setDades($tuples);    // array de tuples
            $this->resposta->setCorrecta(true);       // La resposta es correcta        
            return $this->resposta;
        } catch (Exception $e) {   // hi ha un error posam la resposta a fals i tornam missatge d'error
            $this->resposta->setCorrecta(false, $e->getMessage());
            return $this->resposta;
        }
    }

    public function insert($data) {
        try {
            $sql = "SELECT max(id_aut) as N from AUTORS";
            $stm = $this->conn->prepare($sql);
            $stm->execute();
            $row = $stm->fetch();
            $id_aut = $row["N"] + 1;
            $nom_aut = $data['nom_aut'];
            $fk_nacionalitat = $data['fk_nacionalitat'];

            $sql = "INSERT INTO AUTORS
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
        try {
            $id_aut = $data['id_aut'];
            $nom_aut = $data['nom_aut'];
            $fk_nacionalitat = $data['fk_nacionalitat'];

            $sql = "UPDATE `AUTORS` SET `NOM_AUT`=':nom_aut', `FK_NACIONALITAT`=':fk_nacionalitat' WHERE ID_AUT=':id_aut'";

            $stm = $this->conn->prepare($sql);
            $stm->bindValue(':id_aut', $id_aut);
            $stm->bindValue(':nom_aut', $nom_aut);
            $stm->bindValue(':fk_nacionalitat', !empty($fk_nacionalitat) ? $fk_nacionalitat : NULL, PDO::PARAM_STR);
            $stm->execute();

            $this->resposta->setCorrecta(true);
            return $this->resposta;
        } catch (Exception $e) {
            $this->resposta->setCorrecta(false, "Error mofificant: " . $e->getMessage());
            return $this->resposta;
        }
    }

    public function delete($id) {
        try {
            $sql = "DELETE FROM `AUTORS` WHERE ID_AUT=:id_aut";
            
            $stm = $this->conn->prepare($sql);
            $stm->bindValue(':id_aut', $id);
            $stm->execute();
            $this->resposta->setCorrecta(true);
            return $this->resposta;
        } catch (Exception $ex) {
            $this->resposta->setCorrecta(false, "Error eliminant: " . $e->getMessage());
            return $this->resposta;
        }
    }

    public function filtra($where, $orderby, $offset, $count) {
        try {
            $where = (!empty($where) ? "WHERE ".$where : "");
            $orderby = (!empty($orderby) ? $orderby : "id_aut");
            $offset = (!empty($offset) ? $offset : "0");
            $count = (!empty($count) ? $count : "20");
            
            $result = array();
            $sql = "SELECT id_aut,nom_aut,fk_nacionalitat FROM AUTORS $where ORDER BY $orderby LIMIT $offset,$count";
            $stm = $this->conn->prepare($sql);
            $stm->execute();
            $tuples = $stm->fetchAll();
            $this->resposta->setDades($tuples);
            $this->resposta->setCorrecta(true);      
            return $this->resposta;
        } catch (Exception $e) {
            $this->resposta->setCorrecta(false, "Error cercant: " . $e->getMessage());
            return $this->resposta;
        }
    }
}
