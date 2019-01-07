<?php

//
$base = __DIR__;
require_once("$base/model/llibre.class.php");
$llibre = new Llibre();
if (isset($_POST["TITOL"])) {
    $titol = $_POST["TITOL"];
    $numEdicio = isset($_POST['NUMEDICIO']) ? $_POST['NUMEDICIO'] : NULL;
    $llocEdicio = isset($_POST['LLOCEDICIO']) ? $_POST['LLOCEDICIO'] : NULL;
    $anyEdicio = isset($_POST['ANYEDICIO']) ? $_POST['ANYEDICIO'] : NULL;
    $descripcio_llib = isset($_POST['DESCRIP_LLIB']) ? $_POST['DESCRIP_LLIB'] : NULL;
    $isbn = isset($_POST['ISBN']) ? $_POST['ISBN'] : NULL;
    $deplegal = isset($_POST['DEPLEGAL']) ? $_POST['DEPLEGAL'] : NULL;
    $signtop = isset($_POST['SIGNTOP']) ? $_POST['SIGNTOP'] : NULL;
    $databaixa_llib = isset($_POST['DATBAIXA_LLIB']) ? $_POST['DATBAIXA_LLIB'] : NULL;
    $motiubaixa = isset($_POST['MOTIUBAIXA']) ? $_POST['MOTIUBAIXA'] : NULL;
    $fk_colleccio = isset($_POST['FK_COLLECCIO']) ? $_POST['FK_COLLECCIO'] : NULL;
    $fk_depart = isset($_POST['FK_DEPARTAMENT']) ? $_POST['FK_DEPARTAMENT'] : NULL;
    $fk_idedit = isset($_POST['FK_IDEDIT']) ? $_POST['FK_IDEDIT'] : NULL;
    $fk_llengua = isset($_POST['FK_LLENGUA']) ? $_POST['FK_LLENGUA'] : NULL;
    $img_llib = isset($_POST['IMG_LLIB']) ? $_POST['IMG_LLIB'] : NULL;

    $res = $llibre->insert(array("TITOL" => $titol, "NUMEDICIO" => $numEdicio, "LLOCEDICIO" => $llocEdicio,
        "ANYEDICIO" => $anyEdicio, "DESCRIP_LLIB" => $descripcio_llib, "ISBN" => $isbn, "DEPLEGAL" => $deplegal, "SIGNTOP" => $signtop, "DATBAIXA_LLIB" => $databaixa_llib,
        "MOTIUBAIXA" => $motiubaixa, "FK_COLLECCIO" => $fk_colleccio, "FK_DEPARTAMENT" => $fk_depart, "FK_IDEDIT" => $fk_idedit, "FK_LLENGUA" => $fk_llengua, "IMG_LLIB" => $img_llib));
} else {
    $res = new Resposta();
    $res->SetCorrecta(false, "titol requerit");
}
header('Content-type: application/json');
echo json_encode($res);
