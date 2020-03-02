<?php
require_once "./libs/Database.php";
require_once "./Models/Usuario.php";
require_once "BaseController.php";
class sesionController extends BaseController
{
private $usuario;

private static $instancia = null;
private function __construct()
{
}
private function __clone()
{
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

        if (isset($_SESSION["sesion"])):
            self::$instancia = unserialize($_SESSION["sesion"] ) ;
        else:
            if (self::$instancia===null)
                self::$instancia = new sesionController() ;
        endif ;

        return self::$instancia ;

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
    $db = new Database();

    if ($db->query("SELECT * FROM usuario WHERE correo='$correo' AND contrasenia='$pass'")){
        $this->usuario = $db->getObject("Usuario"); // probar un con print r o vardump
        json_encode($this->usuario);
      //  echo "<pre>" . print_r($this->usuario, true) . "</pre>" ;

        $_SESSION["sesion"] = serialize(self::$instancia);
        return true;
    } else {
        return false;
    }
}



}