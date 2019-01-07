<?php
$base = __DIR__;
 require_once("$base/model/autor.class.php");
 require_once("$base/model/llibre.class.php");
 $autor=new Autor();
 $llibre=new Llibre();
 $res=$autor->getAll();
 if ($res->correcta) {
    foreach ($res->dades as $row){
        echo $row['id_aut']."-".$row['nom_aut']." ".$row["fk_nacionalitat"]."<br>";
    }
 } else {
     echo $res->missatge;
 }
$llibre->insert(array("TITOL"=>"Hola,que hace?", "NUMEDICIO" =>"HOls", "LLOCEDICIO"=>"", "ANYEDICIO"=>"", "DESCRIP_LLIB"=>"", "ISBN"=>"", "DEPLEGAL"=>"", "SIGNTOP"=>"", "DATBAIXA_LLIB"=>"", "MOTIUBAIXA"=>"", "FK_COLLECCIO"=>"", "FK_DEPARTAMENT"=>"", "FK_IDEDIT"=>"", "FK_LLENGUA"=>"", "IMG_LLIB"=>""));
 //$autor->insert(array("nom_aut"=>"Tomeu Campaner","fk_nacionalitat"=>"MURERA"));   //produira un error
 if (!$res->correcta) {
    echo "Error insertant";  // Error per l'usuari
    error_log($res->missatge,3,"$base/log/errors.log");  // Error per noltros
 }   

