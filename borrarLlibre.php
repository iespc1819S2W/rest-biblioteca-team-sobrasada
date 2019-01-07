<?php
$base = __DIR__;
require_once("$base/model/llibre.class.php");
$llibre=new Llibre();
if (isset($_POST["idLlibre"])) {
    $res=$llibre->borrarLlibre($_POST["idLlibre"]);
} else {
    $res=new Resposta();
    $res->SetCorrecta(false,"idLlibre requerit");
}
header('Content-type: application/json');
echo json_encode($res); 