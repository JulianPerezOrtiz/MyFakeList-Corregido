<?php
require_once("./Database.php");
$db = Database::getInstancia("root","","myanimelistV2");


if (($_POST["ope"] == "nick") ) {
    $txt = addslashes($_POST["txt"]) ;

    $query="SELECT * FROM usuario WHERE alias LIKE '$txt'";

   if ($db->query($query)) {
    echo "repetidoNick";
   }


}

if (($_POST["ope"] == "mail") ) {
    $txt = addslashes($_POST["txt"]) ;

    $query="SELECT * FROM usuario WHERE correo LIKE '$txt'";

   if ($db->query($query)) {
       echo "repetidoMail";
   }


}