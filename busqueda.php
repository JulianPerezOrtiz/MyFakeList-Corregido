<?php
require_once("./Database.php");
require_once("./infoSeries.php");


    $text = isset($_POST["nombre"]);
    $db = Database::getInstancia("root","","myanimelistV2");
    $sql = "SELECT * FROM serie WHERE titulo LIKE '$text%'";
    $prep = $db->query($sql);
    $prep->execute();
    $item = $db->getObject("infoSeries");
    echo "HOLA QUE ASE";
    echo "<pre>".print_r($item, true)."</pre>" ;

?>