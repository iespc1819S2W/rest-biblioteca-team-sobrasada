<?php
//
 $base = __DIR__;
 require_once("$base/model/llibre.class.php");
 $llibre=new Llibre();
 if (isset($_POST["titol"])) {
     $titol=$_POST["titol"];
     $res=$titol->insert(array("titol"=>$titol));
 } else {
     $res=new Resposta();
     $res->SetCorrecta(false,"titol requerit");
 }
 header('Content-type: application/json');
 echo json_encode($res); 

