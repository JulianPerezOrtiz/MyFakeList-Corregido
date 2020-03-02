<?php
//require_once "controladores/SerieController.php";
//$hola = new SerieController();
/* require_once "Controller/SerieController.php";
$hola = new SerieController();

$hola->capitulosAleatorios();
*/
/* require_once "libs/SesionController.php";
$ses = sesionController::getInstancia();
if (!($ses->loged())){
    $visitante = true;
} else {
    $visitante = false;
    $user = $ses->getUsu();
     echo "<pre>" . print_r($user, true) . "</pre>" ;
} */
if (isset($_POST["ope"])){
    $ope = $_POST["ope"] ?? "" ;
    $con = $_POST["con"] ?? "";
} else {
    $ope = $_GET["ope"] ?? "inicio" ;
    $con = $_GET["con"] ?? "Serie" ;
}


/*
if ( $ope == "borrar" && $con == "serie"){
    $hola->borrar();

}
*/
$nom = "{$con}Controller" ;

require_once "Controller/$nom.php" ;

$controller = new $nom() ;


$controller->$ope() ;
/*
$ope = $_GET["ope"]??"mostrar" ;
$con = $_GET["con"]??"serie" ;

/*
if ( $ope == "borrar" && $con == "serie"){
    $hola->borrar();
}
*/ /*
$nom = "{$con}Controller" ;

require_once "controladores/$nom.php" ;

$controller = new $nom() ;

// invocamos la operación a realizar
$controller->$ope() ;

//$hola->mostar();

*/