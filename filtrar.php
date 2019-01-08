<?php

//
$base = __DIR__;
require_once("$base/model/llibre.class.php");
$llibre = new Llibre();
if (empty($_GET)) {
    $res = new Resposta();
    $res->SetCorrecta(false, "S'han de passar paramentres.");
} else {
    // $where,$orderby,$offset,$count
    $where = isset($_GET["where"]) ? $_GET["where"] : '';
    $orderby = isset($_GET["orderby"]) ? $_GET["orderby"] : '';
    $res = $llibre->filtra($where, $orderby, $offset, $count);
}
header('Content-type: application/json');
echo json_encode($res);
