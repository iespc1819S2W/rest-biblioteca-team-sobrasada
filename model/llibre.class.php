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

    public function getAll($orderby = "id_llibre")
    {
        try {
            $result = array();
            $stm = $this->conn->prepare("SELECT id_aut,nom_aut,fk_nacionalitat FROM autors ORDER BY $orderby");
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

    public function get($id)
    {
        //TODO
    }

    public function insert($data)
    {
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

}
