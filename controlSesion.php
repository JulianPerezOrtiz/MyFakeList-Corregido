<?php
require_once("./Database.php");
require_once("./usuario.php");

class controlSesion
{
private $usuario;
private $tiempo_sess = 100;

private static $instancia = null;
private function __construct()
{
}
private function __clone()
{
    // TODO: Implement __clone() method.
}
public function close(){
    $_SESSION = [];
    session_destroy();
}
public function getUsu() {
  return  $this->usuario;
}
public function actualizaUsu(){
   return $this->usuario;
}
    public static function getInstancia(){
        session_start() ;

        // comprobamos
        if (isset($_SESSION["sesion"])):
            self::$instancia = unserialize($_SESSION["sesion"] ) ;
        else:
            if (self::$instancia===null)
                self::$instancia = new controlSesion() ;
        endif ;

        // devolvemos la instancia
        return self::$instancia ;
    /*
    session_start();
    if ($_SESSION["_sesion"]){
        self::$instancia = unserialize($_SESSION["_sesion"]);
    } else if (self::$instancia = null) {
        self::$instancia = new controlSesion();
    }
       return self::$instancia; */
}
public function loged():bool {

        return !empty($_SESSION);

}
public function logout(){
    $_SESSION = [ ];
    session_destroy();

}
public function rediret($dir){
    header("Location: $dir");
    die();
}
public function entrar($correo, $pass){
    $dab = Database::getInstancia("root","","myanimelistV2");

    $consulta = "SELECT * FROM usuario WHERE correo='$correo' AND contrasenia='$pass'";
    if ($dab->query($consulta)){
        $this->usuario = $dab->getObject("usuario"); // probar un con print r o vardump
        json_encode($this->usuario);
       // echo "<pre>" . print_r($this->usuario, true) . "</pre>" ;

        $_SESSION["time"] = time();
        $_SESSION["sesion"] = serialize(self::$instancia);
        return true;
    } else {
        return false;
    }
}



}