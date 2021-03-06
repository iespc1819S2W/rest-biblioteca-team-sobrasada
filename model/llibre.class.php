<?php

$base = __DIR__ . '/..';
require_once "$base/lib/resposta.class.php";
require_once "$base/lib/database.class.php";

class Llibre
{

    private $conn; //connexió a la base de dades (PDO)
    private $resposta; // resposta

    public function __CONSTRUCT()
    {
        $this->conn = Database::getInstance()->getConnection();
        $this->resposta = new Resposta();
    }
    public function getAll($orderby = "id_llib") {

        try {
            $result = array();
            $stm = $this->conn->prepare("SELECT * FROM LLIBRES ORDER BY $orderby");
            $stm->execute();
            $tuples = $stm->fetchAll();
            $this->resposta->setDades($tuples); // array de tuples
            $this->resposta->setCorrecta(true); // La resposta es correcta
            return $this->resposta;
        } catch (Exception $e) { // hi ha un error posam la resposta a fals i tornam missatge d'error
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

    public function insert($data)
    {
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

    public function modificaLlibre($dades)
    {
        try {
            /*PROBLEMA, he de montar l'sql perque si pos directament a l'sql el nom de les columnes i el vindvalues,
            si li pas per post 3 columnes, borrará les demés*/
            $sql = "UPDATE LLIBRES SET";
            $strAfegir = "";
            $stm = $this->conn->prepare($sql);
            if ($dades["titol"] != null) {
                $strAfegir .= ", TITOL = :titol";

            }
            if ($dades["numEdicio"] != null) {
                $strAfegir .= ", NUMEDICIO = :numEdicio";

            }
            if ($dades["llocEdicio"] != null) {
                $strAfegir .= ", LLOCEDICIO = :llocEdicio";

            }
            if ($dades["anyEdicio"] != null) {
                $strAfegir .= ", ANYEDICIO = :anyEdicio";

            }
            if ($dades["descripcio"] != null) {
                $strAfegir .= ", DESCRIP_LLIB = :descripcio";

            }
            if ($dades["isbn"] != null) {
                $strAfegir .= ", ISBN = :isbn";

            }
            if ($dades["deplegal"] != null) {
                $strAfegir .= ", DEPLEGAL = :deplegal";

            }
            if ($dades["signtop"] != null) {
                $strAfegir .= ", SIGNTOP = :signtop";

            }
            if ($dades["dataBaixa"] != null) {
                $strAfegir .= ", DATBAIXA_LLIB = :dataBaixa";

            }
            if ($dades["motiuBaixa"] != null) {
                $strAfegir .= ", MOTIUBAIXA = :motiuBaixa";

            }
            if ($dades["fkCollecio"] != null) {
                $strAfegir .= ", FK_COLLECCIO = :fkCollecio";

            }
            if ($dades["fkDepartament"] != null) {
                $strAfegir .= ", FK_DEPARTAMENT = :fkDepartament";

            }
            if ($dades["fkIdEditor"] != null) {
                $strAfegir .= ", FK_IDEDIT = :fkIdEditor";

            }
            if ($dades["fkLlengua"] != null) {
                $strAfegir .= ", FK_LLENGUA = :fkLlengua";

            }
            if ($dades["imatge"] != null) {
                $strAfegir .= ", IMG_LLIB = :imatge";

            }
            if ($dades["idLlibre"] != null) {
                $strAfegir .= " WHERE ID_LLIB = :idLlibre";

            }
            $strAfegir = trim($strAfegir, ",");
            $sql .= $strAfegir;
            $stm = $this->conn->prepare($sql);
            if ($dades["titol"] != null) {
                $stm->bindValue(':titol', $dades["titol"], PDO::PARAM_STR);
            }
            if ($dades["numEdicio"] != null) {
                $stm->bindValue(':numEdicio', $dades["numEdicio"], PDO::PARAM_STR);
            }
            if ($dades["llocEdicio"] != null) {
                $stm->bindValue(':llocEdicio', $dades["llocEdicio"], PDO::PARAM_STR);
            }
            if ($dades["anyEdicio"] != null) {
                $stm->bindValue(':anyEdicio', $dades["anyEdicio"], PDO::PARAM_INT);
            }
            if ($dades["descripcio"] != null) {
                $stm->bindValue(':descripcio', $dades["descripcio"], PDO::PARAM_STR);
            }
            if ($dades["isbn"] != null) {
                $stm->bindValue(':isbn', $dades["isbn"], PDO::PARAM_STR);
            }
            if ($dades["deplegal"] != null) {
                $stm->bindValue(':deplegal', $dades["deplegal"], PDO::PARAM_STR);
            }
            if ($dades["signtop"] != null) {
                $stm->bindValue(':signtop', $dades["signtop"], PDO::PARAM_STR);
            }
            if ($dades["dataBaixa"] != null) {
                $stm->bindValue(':dataBaixa', $dades["dataBaixa"], PDO::PARAM_STR);
            }
            if ($dades["motiuBaixa"] != null) {
                $stm->bindValue(':motiuBaixa', $dades["motiuBaixa"], PDO::PARAM_STR);
            }
            if ($dades["fkCollecio"] != null) {
                $stm->bindValue(':fkCollecio', $dades["fkCollecio"], PDO::PARAM_STR);
            }
            if ($dades["fkDepartament"] != null) {
                $stm->bindValue(':fkDepartament', $dades["fkDepartament"], PDO::PARAM_STR);
            }
            if ($dades["fkIdEditor"] != null) {
                $stm->bindValue(':fkIdEditor', $dades["fkIdEditor"], PDO::PARAM_INT);
            }
            if ($dades["fkLlengua"] != null) {
                $stm->bindValue(':fkLlengua', $dades["fkLlengua"], PDO::PARAM_STR);
            }
            if ($dades["imatge"] != null) {
                $stm->bindValue(':imatge', $dades["imatge"], PDO::PARAM_STR);
            }
            if ($dades["idLlibre"] != null) {
                $stm->bindValue(':idLlibre', $dades["idLlibre"], PDO::PARAM_INT);
            }
            $stm->execute();
            $this->resposta->setCorrecta(true);
            return $this->resposta;
        } catch (Exception $e) {
            $this->resposta->setCorrecta(false, "Error modificant: " . $e->getMessage());
            return $this->resposta;
        }

    }

    public function borrarLlibre($id){
        try{
        $sql = "DELETE FROM LLIBRES WHERE ID_LLIB = :idLlib";
        $stm = $this->conn->prepare($sql);
        $stm->bindValue(':idLlib', $id, PDO::PARAM_INT);
        $stm->execute();
        $this->resposta->setCorrecta(true);
        return $this->resposta;
        } catch(Exception $e){
            $this->resposta->setCorrecta(false, "Error borrant: " . $e->getMessage());
            return $this->resposta;
        }
    }
    public function filtra($where, $orderby) {
        try {
            $buscar = true;
            $limit = false;
            $ntuplas = false;
            $sql = "SELECT * from LLIBRES";
            if (strlen($where) == 0) {
                $buscar = false;
            } else if (is_numeric($where)) {
                $sql = $sql . " WHERE id_llib like :w";
            } else {
                $sql = $sql . " WHERE titol like :w";
            }

            if (strlen($orderby) == 0) {
                
            } else {
                $orderby = filter_var($orderby, FILTER_SANITIZE_STRING);
                $sql = $sql . " ORDER BY $orderby";
            }
            if ($count != "") {
                $limit = true;
                if ($offset != "") {
                    $ntuplas = true;
                    $sql = $sql . " limit :offset, :count";
                } else {
                    $sql = $sql . " limit :count";
                }
            }
            $stm = $this->conn->prepare($sql);

            if ($buscar) {
                $stm->bindValue(':w', '%' . $where . '%');
            }

            $stm->execute();
            $tuples = $stm->fetchAll();

            $this->resposta->setDades($tuples);
            $this->resposta->setCorrecta(true);
            return $this->resposta;
        } catch (Exeption $e) {
            $this->resposta->setCorrecta(false, "Error insertant: " . $e->getMessage());
            return $this->resposta;
        }
    }
}
