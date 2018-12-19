
<?php
// get autor
 $base = __DIR__;
 require_once("$base/model/llibre.class.php");
 $llibre=new Llibre();
 $id_llib=$_GET["id"];
 $res=$llibre->get($id_llib);
 header('Content-type: application/json');
 echo json_encode($res);