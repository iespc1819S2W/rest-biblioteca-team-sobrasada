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

    public function allAutorllibres($id){
        try{
            $id_llib = $id;
            //select nom_aut from autors,llibres,lli_aut where id_aut = fk_idaut and id_llib = fk_idllib and id_llib = 1
            $sql = "SELECT * FROM AUTORS,LLIBRES,LLI_AUT WHERE ID_AUT = FK_IDAUT AND ID_LLIB = FK_IDLLIB and ID_LLIB = :id_llib";
            $stm = $this->conn->prepare($sql);
            $stm->bindValue(":id_llib",$id_llib);
            $stm->execute();
            $row = $stm->fetchAll();
            $this->resposta->SetDades($row);
            $this->resposta->SetCorrecta(true);
            return $this->resposta;

        }catch(Exception $e){
            $this->resposta->setCorrecta(false, $e->getMessage());
            return $this->resposta;
        }
    }
}
