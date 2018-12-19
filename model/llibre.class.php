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
        //TODO
    }

    public function insert($data) {
        try {
            $sql = "SELECT max(id_llib) as N from llibres";
            $stm = $this->conn->prepare($sql);
            $stm->execute();
            $row = $stm->fetch();
            $id_llib = $row["N"] + 1;
            $titol = $data['TITOL'];
            $numEdicio = $data['NUMEDICIO'];
            $llocEdicio = $data['LLOCEDICIO'];
            $anyEdicio = $data['ANYEDICIO'];
            $descLlibre = $data['DESCRIP_LLIB'];
            $isbn = $data['ISBN'];
            $deplegal = $data['DEPLEGAL'];
            $signtop = $data['SIGNTOP'];
            $dataBaixa = $data['DATBAIXA_LLIB'];
            $motiuBaixa = $data['MOTIUBAIXA'];
            $fkColleccio = $data['FK_COLLECCIO'];
            $fkDepart = $data['FK_DEPARTAMENT'];
            $fkIdedit = $data['FK_IDEDIT'];
            $fkLlengua = $data['FK_LLENGUA'];
            $imgLlib = $data['IMG_LLIB'];

            $sql = "INSERT INTO llibres
                            (ID_LLIB, TITOL, NUMEDICIO, LLOCEDICIO, ANYEDICIO, DESCRIP_LLIB, ISBN, DEPLEGAL, SIGNTOP, DATBAIXA_LLIB, MOTIUBAIXA, FK_COLLECCIO, FK_DEPARTAMENT, FK_IDEDIT, FK_LLENGUA, IMG_LLIB)
                            VALUES (:id_llib,:titol,:numedicio,:llocedicio,:anyedicio,:descripcio_llib,:isbn,:deplegal,:signtop,:databaixa_llib,:motiubaixa,:fk_colleccio,:fk_departament,:fk_idedit,:fk_llengua,:img_llib)";

            $stm = $this->conn->prepare($sql);
            $stm->bindValue(':id_llib', $id_llib);
            $stm->bindValue(':titol', $titol);
            $stm->bindValue(':numedicio', !empty($numEdicio) ? $numEdicio : NULL, PDO::PARAM_STR);
            $stm->bindValue(':llocedicio', !empty($llocEdicio) ? $llocEdicio : NULL, PDO::PARAM_STR);
            $stm->bindValue(':anyedicio', !empty($anyEdicio) ? $anyEdicio : NULL, PDO::PARAM_STR);
            $stm->bindValue(':descripcio_llib', !empty($descLlibre) ? $descLlibre : NULL, PDO::PARAM_STR);
            $stm->bindValue(':isbn', !empty($isbn) ? $isbn : NULL, PDO::PARAM_STR);
            $stm->bindValue(':deplegal', !empty($deplegal) ? $deplegal : NULL, PDO::PARAM_STR);
            $stm->bindValue(':signtop', !empty($signtop) ? $signtop : NULL, PDO::PARAM_STR);
            $stm->bindValue(':databaixa_llib', !empty($dataBaixa) ? $dataBaixa : NULL, PDO::PARAM_STR);
            $stm->bindValue(':motiubaixa', !empty($motiuBaixa) ? $motiuBaixa : NULL, PDO::PARAM_STR);
            $stm->bindValue(':fk_colleccio', !empty($fkColleccio) ? $fkColleccio : NULL, PDO::PARAM_STR);
            $stm->bindValue(':fk_departament', !empty($fkDepart) ? $fkDepart : NULL, PDO::PARAM_STR);
            $stm->bindValue(':fk_idedit', !empty($fkIdedit) ? $fkIdedit : NULL, PDO::PARAM_STR);
            $stm->bindValue(':fk_llengua', !empty($fkLlengua) ? $fkLlengua : NULL, PDO::PARAM_STR);
            $stm->bindValue(':img_llib', !empty($imgLlib) ? $imgLlib : NULL, PDO::PARAM_STR);
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
