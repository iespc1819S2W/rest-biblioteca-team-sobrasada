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

    public function getAll($orderby = "id_llib") {
        try {
            $result = array();
            $stm = $this->conn->prepare("SELECT * FROM LLIBRES ORDER BY $orderby");
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
            $id_llib = $id;
            $sql = "SELECT * FROM LLIBRES where ID_LLIB = :id_llib";
            $stm=$this->conn->prepare($sql);
            $stm->bindValue(":id_llib",$id_llib);
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
            $sql = "SELECT max(id_llib) as N from llibres";
            $stm = $this->conn->prepare($sql);
            $stm->execute();
            $row = $stm->fetch();
            $id_llib = $row["N"] + 1;
            $titol = $data['titol'];

            $sql = "INSERT INTO llibres
                            (id_llib,titol)
                            VALUES (:id_llib,:titol)";

            $stm = $this->conn->prepare($sql);
            $stm->bindValue(':id_llib', $id_llib);
            $stm->bindValue(':titol', $titol);
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
