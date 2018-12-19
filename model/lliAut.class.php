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
            //select * from lli_aut inner join llibres on fk_idllib = id_llib inner join autors on fk_idaut = id_aut where id_llib = :id_llib;
            //$sql = "SELECT * FROM AUTORS,LLIBRES,LLI_AUT WHERE ID_AUT = FK_IDAUT AND ID_LLIB = FK_IDLLIB and ID_LLIB = :id_llib";
            $sql = "SELECT * FROM LLI_AUT INNER JOIN LLIBRES ON FK_IDLLIB = ID_LLIB INNER JOIN AUTORS ON FK_IDAUT = ID_AUT WHERE ID_LLIB = :id_llib";
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
