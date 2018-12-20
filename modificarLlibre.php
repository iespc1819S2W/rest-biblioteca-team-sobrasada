<?php
$base = __DIR__;
require_once("$base/model/llibre.class.php");
$llibre=new Llibre();
if (isset($_POST["idLlibre"])) {
    $idLlibre=$_POST["idLlibre"];
    $titol=isset($_POST["titol"])?$_POST["titol"]:null;
    $numEdicio=isset($_POST["numEdicio"])?$_POST["numEdicio"]:null;
    $llocEdicio=isset($_POST["llocEdicio"])?$_POST["llocEdicio"]:null;
    $anyEdicio=isset($_POST["anyEdicio"])?$_POST["anyEdicio"]:null;
    $descripcio=isset($_POST["descripcio"])?$_POST["descripcio"]:null;
    $isbn=isset($_POST["isbn"])?$_POST["isbn"]:null;
    $deplegal=isset($_POST["deplegal"])?$_POST["deplegal"]:null;
    $signtop=isset($_POST["signtop"])?$_POST["signtop"]:null;
    $dataBaixa=isset($_POST["dataBaixa"])?$_POST["dataBaixa"]:null;
    $motiuBaixa=isset($_POST["motiuBaixa"])?$_POST["motiuBaixa"]:null;
    $fkCollecio=isset($_POST["fkCollecio"])?$_POST["fkCollecio"]:null;
    $fkDepartament=isset($_POST["fkDepartament"])?$_POST["fkDepartament"]:null;
    $fkIdEditor=isset($_POST["fkIdEditor"])?$_POST["fkIdEditor"]:null;
    $fkLlengua=isset($_POST["fkLlengua"])?$_POST["fkLlengua"]:null;
    $imatge=isset($_POST["imatge"])?$_POST["imatge"]:null;

    $res=$llibre->modificaLlibre(array("idLlibre"=>$idLlibre,"titol"=>$titol,"numEdicio"=>$numEdicio,
    "llocEdicio"=>$llocEdicio,"anyEdicio"=>$anyEdicio,"descripcio"=>$descripcio,"isbn"=>$isbn,
    "deplegal"=>$deplegal,"signtop"=>$signtop,"dataBaixa"=>$dataBaixa,"motiuBaixa"=>$motiuBaixa,
    "fkCollecio"=>$fkCollecio,"fkDepartament"=>$fkDepartament,"fkIdEditor"=>$fkIdEditor,"fkLlengua"=>$fkLlengua,"imatge"=>$imatge));

} else {
    $res=new Resposta();
    $res->SetCorrecta(false,"idLlibre requerit");
}
header('Content-type: application/json');
echo json_encode($res); 