<?php

require_once "BaseController.php";
require_once "SesionController.php";
require_once "./Models/Serie.php";
require_once "./Models/Usuario.php";
require_once "./Models/Estudio.php";
require_once "./Models/Genero.php";
class SerieController extends BaseController
{
public function __construct()
{
    parent::__construct();
}

public function inicio(){
    $ses = sesionController::getInstancia();
    if ( $ses->loged()) {
        $usu = $ses->getUsu();
        echo $this->twig->render("ShowInicio.php.twig", ['visitante' => false, 'usuario' => $usu]);
    } else {
    echo $this->twig->render("ShowInicio.php.twig", ['visitante' => true]);
    }
}

public function capitulosAleatorios(){
    $data = Serie::capsAle();

   // echo "<pre>".print_r($data, true)."</pre>" ;
    echo $this->twig->render("muestraCaps.php.twig" , ['dat' => $data]);
}
public function busqueda(){
    $txt = addslashes($_GET["texto"]);
    $usu = Usuario::bus($txt);
    $data = Serie::bus($txt);
    echo $this->twig->render("busqueda.php.twig" , ['dat' => $data, 'usu' => $usu]);

}
public function mostrarAni(){
    $id = addslashes( $_GET["id"]);
    $serie = Serie::serieId($id);
    $est = Estudio::buscaEst($serie[0]->getIdEst());
    $rel = Serie::relacionados($id);
    $gen = Genero::generos($id);
   // echo "<pre>".print_r($gen, true)."</pre>" ;
    $tipAnt = "";
    foreach ($rel as $seriesRel){
        if ($tipAnt  != $seriesRel["tipo"]) {
            $tip = $seriesRel["tipo"];
            $serRel[] = Serie::seriesRel($id, $tip);
        }
        $tipAnt = $tip;

    }
    if (empty($serRel)){
        $serRel = false;
    }
    //echo "<pre>".print_r($serRel, true)."</pre>" ;
    $ses = sesionController::getInstancia();

    if ( $ses->loged()) {
        $usu = $ses->getUsu();
        $idUsu = $usu[0]->getIdUsu();
        $serSig = Serie::compruebaSerUsu($idUsu,$id);  // devuelve false si no la esta siguiendo o la serie en caso de que si
        $estados = $this->estadosSer();
       // echo "<pre>".print_r($serSig, true)."</pre>" ;
    echo $this->twig->render("anime.php.twig" , ['serie' => $serie, 'est' => $est,'tip' => $rel,'estados' => $estados, 'rel' => $serRel,
                                                        'seg' => $serSig, 'gen' => $gen, "visitante" => false, "usuario" => $usu]);
    } else {
        echo $this->twig->render("anime.php.twig" , ['serie' => $serie, "visitante" => true, 'est' => $est,'gen' => $gen,'tip' => $rel, 'rel' => $serRel]);
    }


}
public function addSer(){

    $idUsu = $_POST["usu"];
    $idSe = $_POST["se"];
    $hoy = getdate();
    if (strlen($hoy["mday"]) == 1){
        $dia = "0".$hoy["mday"];
    }else {
        $dia = $hoy["mday"];
    }
    $ac = $hoy["year"]."-".$hoy["mon"]."-".$dia;
    Serie::addSer($idUsu,$idSe,$ac);


}
public function delSer(){
    $idUsu = addslashes($_POST["usu"]) ;
    $idSe = addslashes($_POST["se"]) ;
    Serie::delSer($idSe, $idUsu);
}
public function estadosSer(){
    $estados = array(
        0 => "Viendo",
        1 => "Para_Ver",
        2 => "Droppeada",
        3 => "Completada"
    );
    return $estados;
}

public function lista() {
    $id = addslashes( $_GET["id"] ?? "");
    $usuVis = Usuario::busUsu($id);
    $ses = sesionController::getInstancia();
    if ($ses->loged() ) {
        $usu = $ses->getUsu();
        $idUsu = $usu[0]->getIdUsu();
        if ($idUsu == $id){
            $list = Serie::lista($idUsu);
          // echo "<pre>".print_r($list, true)."</pre>" ;

            echo $this->twig->render("lista.php.twig" , ['serie' => $list, 'edit' => true, 'visitante' => false,'usuario' => $usu]);
        } else {
            $list = Serie::lista($id);
            echo $this->twig->render("lista.php.twig" , ['serie' => $list,'edit' => false, 'visitante' => false,'usuVis' => $usuVis,'usuario' => $usu]);
        }
    } else {
        $list = Serie::lista($id);
        echo $this->twig->render("lista.php.twig" , ['serie' => $list,'edit' => false,'usuVis' => $usuVis, 'visitante' => true]);
    }
}
public function modStatus(){
    $idUsu = addslashes($_POST["usu"]) ;
    $idSe = addslashes($_POST["se"]) ;
    $text = addslashes($_POST["est"]);
    Serie::modSts($text,$idUsu,$idSe);
}

public function up(){
    $idUsu = $_POST["usu"];
    $idSe = $_POST["se"];
    $CapTo = $_POST["capmax"];
   $aa = Serie::upCap($idUsu, $idSe,$CapTo);
   echo $aa;

}

public function comentario(){
    $idUsu = $_POST["usu"];
    $idSe = $_POST["se"];
    $text = addslashes($_POST["text"]);
    Serie::descripcion($text,$idUsu,$idSe);
    return $text;
}
public function score(){
    $idUsu = $_POST["usu"];
    $idSe = $_POST["se"];
    $sc = addslashes($_POST["sc"]);
    Serie::score($sc,$idUsu,$idSe);
    return $sc;
}

public function favorito(){
    $idUsu = addslashes($_POST["usu"]) ;
    $idSe = addslashes($_POST["se"]) ;
    $fav = addslashes($_POST["opeS"]);

    Serie::fav($fav,$idUsu,$idSe);


}



}