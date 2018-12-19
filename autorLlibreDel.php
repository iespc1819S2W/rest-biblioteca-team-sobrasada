<?php
// delete llibre autor
 $base = __DIR__;
 require_once("$base/model/lliAut.class.php");
 $lliAut=new LliAut();
 $res=$lliAut->delete(array("id_llibre"=>$_POST["id_llibre"],"id_autor"=>$_POST["id_autor"]));
 header('Content-type: application/json');
 echo json_encode($res);
 