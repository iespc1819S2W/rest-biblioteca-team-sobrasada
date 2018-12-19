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

    public function modificaLlibre($dades) {
        try{ 
            /*$sql = "update LLIBRES SET TITOL=:titol , :numEdicio , :llocEdicio , 
        :anyEdicio , :descripcio , :isbn , :deplegal , :signtop , 
        :databaixa, :motiuBaixa , :fkCollecio , :fkDepartament , 
        :fkIdEditor , :fkLlengua , :imatge 
        WHERE ID_LLIB = :idLlibre";*/

        /*PROBLEMA, he de montar l'sql perque si pos directament a l'sql el nom de les columnes i el vindvalues, 
        si li pas per post 3 columnes, borrará les demés*/
        $sql = "update LLIBRES SET ";
        $strAfegir = "";
        if($dades["titol"] != null){
            $strAfegir .= "TITOL = :titol,";
            $stm->bindValue(':titol', $dades["titol"]);
        }
        if($dades["numEdicio"] != null){
            $strAfegir .= "NUMEDICIO = :numEdicio, ";
            $stm->bindValue(':numEdicio', $dades["numEdicio"]);
        }
        if($dades["llocEdicio"] != null){
            $strAfegir .= "LLOCEDICIO = :llocEdicio, ";
            $stm->bindValue(':llocEdicio', $dades["llocEdicio"]);
        }
        if($dades["anyEdicio"] != null){
            $strAfegir .= "ANYEDICIO = :anyEdicio, ";
            $stm->bindValue(':anyEdicio', $dades["anyEdicio"]);
        }
        if($dades["descripcio"] != null){
            $strAfegir .= "DESCRIP_LLIB = :descripcio, ";
            $stm->bindValue(':descripcio', $dades["descripcio"]);
        }
        if($dades["isbn"] != null){
            $strAfegir .= "ISBN = :isbn, ";
            $stm->bindValue(':isbn', $dades["isbn"]);
        }
        if($dades["deplegal"] != null){
            $strAfegir .= "DEPLEGAL = :deplegal, ";
            $stm->bindValue(':deplegal', $dades["deplegal"]);
        }
        if($dades["signtop"] != null){
            $strAfegir .= "SIGNTOP = :signtop, ";
            $stm->bindValue(':signtop', $dades["signtop"]);
        }
        if($dades["databaixa"] != null){
            $strAfegir .= "DATBAIXA_LLIB = :databaixa, ";
            $stm->bindValue(':databaixa', $dades["databaixa"]);
        }
        if($dades["motiuBaixa"] != null){
            $strAfegir .= "MOTIUBAIXA = :motiuBaixa, ";
            $stm->bindValue(':motiuBaixa', $dades["motiuBaixa"]);
        }
        if($dades["fkCollecio"] != null){
            $strAfegir .= "FK_COLLECIO = :fkCollecio, ";
            $stm->bindValue(':fkCollecio', $dades["fkCollecio"]);
        }
        if($dades["fkDepartament"] != null){
            $strAfegir .= "FK_DEPARTAMENT = :fkDepartament, ";
            $stm->bindValue(':fkDepartament', $dades["fkDepartament"]);
        }
        if($dades["fkIdEditor"] != null){
            $strAfegir .= "FK_IDEDIT = :fkIdEditor, ";
            $stm->bindValue(':fkIdEditor', $dades["fkIdEditor"]);
        }
        if($dades["fkLlengua"] != null){
            $strAfegir .= "FK_LLENGUA = :fkLlengua, ";
            $stm->bindValue(':fkLlengua', $dades["fkLlengua"]);
        }
        if($dades["imatge"] != null){
            $strAfegir .= "IMG_LLIB = :imatge, ";
            $stm->bindValue(':imatge', $dades["imatge"]);
        }
        if($dades["idLlibre"] != null){
            $strAfegir .= "WHERE ID_LLIB = :idLlibre";
            $stm->bindValue(':idLlibre', $dades["idLlibre"]);
        }
        $stm = $this->conn->prepare($sql);
        $stm->execute();
        $this->resposta->setCorrecta(true);
        return $this->resposta;
        } catch(Exception $e){
            $this->resposta->setCorrecta(false, "Error modificant: " . $e->getMessage());
            return $this->resposta;
        }

    }

    

}
