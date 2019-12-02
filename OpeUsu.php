<?php
require_once("./Database.php");
require_once("./controlSesion.php");

$db = Database::getInstancia("root","","myanimelistV2");
if (($_POST["ope"] == "location") ||($_POST["ope"] == "about") ) {
    $idUsu = $_POST["usu"];
    $ope = $_POST["ope"];
    $text = addslashes($_POST["txt"]);
    $query="UPDATE usuario SET $ope = '$text' WHERE id_usu = $idUsu";
    echo $query;
    $db->query($query);

}

