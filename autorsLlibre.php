<?php
// get autor
$base = __DIR__;
require_once("$base/model/lliAut.class.php");
$lliAut=new LliAut();
$id_llib=$_GET["id"];
$res=$lliAut->allAutorLlibres($id_llib);
header('Content-type: application/json');
echo json_encode($res);