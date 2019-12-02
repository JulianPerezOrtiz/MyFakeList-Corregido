<?php
require_once("./Database.php");

$db = Database::getInstancia("root","","myanimelistV2");

if ( $_POST["ope"] == "cap" ) {
    $idUsu = $_POST["usu"];
    $idSe = $_POST["se"];
    $CapTo = $_POST["capmax"];
    $capAc = "SELECT cap, status FROM ususer WHERE id_usu = $idUsu AND idSe = $idSe";
    $re = $db->query($capAc);
    $capBD = $db->getArraid();

    $cp = $capBD[0]["cap"];
    $sts = $capBD[0]["status"];
    if ($sts != "Viendo") {
        $query="UPDATE ususer SET status = 'Viendo' WHERE id_usu = $idUsu AND idSe = $idSe";
        $db->query($query);
    }
    if ( $cp + 1 <= $CapTo){
        $cp++;
        $query="UPDATE ususer SET cap = $cp WHERE id_usu = $idUsu AND idSe = $idSe";
        $db->query($query);
        if ($cp != $CapTo) {
            echo $cp;
        }

        ?>

        <?php
    } if ($cp == $CapTo) {
        $hoy = getdate();
        if (strlen($hoy["mday"]) == 1){
            $dia = "0".$hoy["mday"];
        }
        $ac = $hoy["year"]."-".$hoy["mon"]."-".$dia;
        $query="UPDATE ususer SET status = 'Completada' WHERE id_usu = $idUsu AND idSe = $idSe";
        $db->query($query);
        $query="UPDATE ususer SET fec_finS = '$ac' WHERE id_usu = $idUsu AND idSe = $idSe";
        $db->query($query);
        echo $cp;
    }
}
if ($_POST["ope"] == "sc") {
    $idUsu = $_POST["usu"];
    $idSe = $_POST["se"];
    $sc = addslashes($_POST["sc"]);
    $query="UPDATE ususer SET score = $sc WHERE id_usu = $idUsu AND idSe = $idSe";
    $db->query($query);
    echo $sc;
}
if ($_POST["ope"] == "des") {
    $idUsu = $_POST["usu"];
    $idSe = $_POST["se"];
    $text = addslashes($_POST["text"]);
    $query="UPDATE ususer SET review = '$text' WHERE id_usu = $idUsu AND idSe = $idSe";
    $db->query($query);
    echo $text;
}
if ($_POST["ope"] == "modSe") {
    $idUsu = addslashes($_POST["usu"]) ;
    $idSe = addslashes($_POST["se"]) ;
    $text = addslashes($_POST["est"]);
    $query="UPDATE ususer SET status = '$text' WHERE id_usu = $idUsu AND idSe = $idSe";
    $db->query($query);
}
if ($_POST["ope"] == "status"){
    $idUsu = $_POST["usu"];
    $idSe = $_POST["se"];
    $text = addslashes($_POST["sts"]);
    $hoy = getdate();
    if (strlen($hoy["mday"]) == 1){
        $dia = "0".$hoy["mday"];
    }
    $ac = $hoy["year"]."-".$hoy["mon"]."-".$dia;

    $qer = "INSERT INTO `ususer` (`id_usu`, `idSe`, `cap`, `status`, `score`, `review`, `fec_inic`, `fec_finS`) 
            VALUES ('$idUsu', '$idSe', '0', 'Para_Ver', NULL, NULL, '$ac', NULL) ";

    $db->query($qer);

}
if ($_POST["ope"] == "del"){
    $idUsu = addslashes($_POST["usu"]) ;
    $idSe = addslashes($_POST["se"]) ;


    $qer = "DELETE FROM ususer WHERE idSe = $idSe AND id_usu = $idUsu ";

    $db->query($qer);

}
if ($_POST["ope"] == "fav"){
    $idUsu = addslashes($_POST["usu"]) ;
    $idSe = addslashes($_POST["se"]) ;
    $fav = addslashes($_POST["opeS"]);

    $qer = "UPDATE ususer SET favoritausu = $fav WHERE id_usu = $idUsu AND idSe = $idSe ";
    $db->query($qer);

}




?>

