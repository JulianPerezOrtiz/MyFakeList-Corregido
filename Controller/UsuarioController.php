<?php

use mysql_xdevapi\Session;

require_once "BaseController.php";
require_once "./Models/Usuario.php";
require_once "./Models/Serie.php";
require_once "SerieController.php";
class UsuarioController extends BaseController
{
public function __construct()
{
    parent::__construct();
}

public function mostarPerfil(){
    $ses = sesionController::getInstancia();
     $perfil = $_GET["id"]  ?? "";
    addslashes($perfil);
    if ($ses->loged()){
        $usu = $ses->getUsu();
        if ($perfil == $usu[0]->getIdUsu()){
            if (!empty($_FILES)){
                $this->subeFoto($usu[0]->getidUsu());
            }
            $favusu = Serie::favUsu($usu[0]->getIdUsu());
            $usu = Usuario::busUsu($usu[0]->getIdUsu()); // actualiza de nuevo el perfil
            echo $this->twig->render("Perfil.php.twig", ["visitante" => false, "usuario" => $usu, "fav" => $favusu]);
        } else {
            // Si estas logueado y vas a ver el perfil de otra persona
            if (is_numeric($perfil) ) {
                $vis = Usuario::busUsu($perfil);
            }
            if (empty($vis)){
             $ses->rediret("index.php");
            } else {

                    $favusu = Serie::favUsu($perfil);


                if ($ses->loged()) {
                    echo $this->twig->render("Perfil.php.twig", ["visitante" => false, "usuario" => $usu, "fav" => $favusu, "pervis" => $vis]);
                }
            }


        }
    } else { // si eres un visitante y vas a ver otro perfil
        if (is_numeric($perfil)) {
            $vis = Usuario::busUsu($perfil);
        }

        if (empty($vis)) {
            $ses->rediret("index.php");
        } else {
            $favusu = Serie::favUsu($perfil);
            echo $this->twig->render("Perfil.php.twig", ["visitante" => true, "fav" => $favusu, "pervis" => $vis]);
        }

    }
}

public function subeFoto($usu){
    $ori = $_FILES["img"]["tmp_name"];
    $fin = "C:\Users\julia\PhpstormProjects\MyanimelistTwig\avatares\\".$usu.".jpg";
    //   echo $fin;

    if (!move_uploaded_file($ori,$fin)){
        echo "Error al subir la foto.";
    } else {
        $photo = $usu.".jpg";
        // le paso la ruta del la image
        //   $img = imagecreatefromjpeg($fin);
        //  imagescale($img, 10,10);
        Usuario::subeFoto($photo, $usu );

    }
}
public function actuInfo(){

        $idUsu = $_POST["usu"];
        $ope = $_POST["ope1"];
        $text = addslashes($_POST["txt"]);
        Usuario::actuPer($ope,$text,$idUsu);
        $ser = sesionController::getInstancia();
        $ser->actualizaUsu();
        echo $idUsu;
        return $idUsu;
}

public function login(){
    $ses = SesionController::getInstancia();

    if ( $ses->loged()) {
        $ses->rediret("index.php");
    } else {
        if (!isset($_POST["mail"]) ) {
            echo $this->twig->render("login.php.twig",['visitante' => true]);
        } else {

            $mail = addslashes($_POST["mail"]);
            $pass = addslashes(hash('sha256', $_POST["pass"]));
            $ok = $ses->entrar($mail,$pass);
            if ($ok){
                  $usu = $ses->getUsu();
               //    echo "<pre>" . print_r($usu, true) . "</pre>" ;

                $ses->rediret("index.php");
            } else {
               echo $this->twig->render("login.php.twig", [ 'error' => true,'visitante' => true]);
            }
        }
    }


}
public function registro(){
    $ses = SesionController::getInstancia();
    if ( $ses->loged()) {
        $ses->rediret("index.php");
    } else {
        if (!empty($_POST)){
            $correo = addslashes( $_POST["correo"]);
            $contrasenia = hash('sha256',$_POST["contrasenia"]);
            $confcontrasenia = hash('sha256', $_POST["confircontrasenia"]);
            $nick = addslashes($_POST["nick"]);

            if ($contrasenia == $confcontrasenia) {
                $hoy = getdate();
                if (strlen($hoy["mday"]) == 1){
                    $dia = "0".$hoy["mday"];
                } else {
                    $dia = $hoy["mday"];
                }
                $ac = $hoy["year"]."-".$hoy["mon"]."-".$dia;



                if ( Usuario::registro($nick,$correo,$contrasenia,$ac)){
                    echo $this->twig->render("registro.php.twig", ['visitante' => true,'corr' => true]);
                } else { // si hay error del servidor
                    echo $this->twig->render("registro.php.twig", ['visitante' => true,'errorInt' => true]);
                }


            } else { // si las contraseñas no coinciden

                echo $this->twig->render("registro.php.twig", ['visitante' => true,'error' => true]);
            }


        } else {
            echo $this->twig->render("registro.php.twig", ['visitante' => true]);
        }

    }

}
public function comNick(){
    $txt = addslashes($_POST["txt"]) ;

    if (Usuario::conNick($txt)){
        echo "repetidoNick";
    }
}
public function comMail(){
    $txt = addslashes($_POST["txt"]) ;
    if (Usuario::comMail($txt)){
        echo "repetidoMail";
    }
}
public function logout(){
    $ses = sesionController::getInstancia();
    $ses->logout();
    $ses->rediret("./index.php");
}

}