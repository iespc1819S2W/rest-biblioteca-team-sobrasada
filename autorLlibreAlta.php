<?php
// insert llibre autor
 $base = __DIR__;
 require_once("$base/model/lliAut.class.php");
 $lliAut=new LliAut();
 $rol = (!empty($_POST["rol"]) ? $_POST["rol"] : NULL);
 $res=$lliAut->insert(array("id_llibre"=>$_POST["id_llibre"],"id_autor"=>$_POST["id_autor"],"rol"=>$rol));
 header('Content-type: application/json');
 echo json_encode($res);
 