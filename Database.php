<?php

require_once("./usuario.php");
require_once("infoSeries.php");
require_once("./relacionados.php");
class Database

{
private $host = "localhost";
private $dbname;
private $usu;
private $pass;
    /**
     * @var PDO
     */
private $resultado;
    /**
     * @var PDO
     */
private $pdo;
private static $instancia = null;

private function __construct($usu,$pass, $dbname ){
    $this->dbname = $dbname;
    $this->usu = $usu;
    $this->pass = $pass;

    $this->conectar();
}
public static function getInstancia($usuDB, $passDB, $nombreDB ){
     if (Database::$instancia == null) {


         Database::$instancia = new Database($usuDB, $passDB, $nombreDB);
}
     return Database::$instancia;
}
public function getHost(){
    return $this->host;
}
public function __destruct()
{
    $this->pdo = null;
}

    private function conectar(){
    //$this->pdo = new PDO("mysql:host=".$this->host.";dbname="."$this->dbname","$this->usu","$this->pass");

        try {
            $this->pdo = new PDO("mysql:host=".$this->host.";dbname=".$this->dbname,$this->usu,$this->pass);
            $this->pdo->exec("set names utf8");
        } catch (PDOException $e){
            die("error al conectar a la bd: ".$e->getMessage());
        }



}
public function query($consulta):bool {
    try {

        $this->pdo->prepare($consulta);


        $this->resultado = $this->pdo->query($consulta);

} catch (PDOException $error){
die("ERROR AL HACER LA CONSULTA: ".$error->getMessage());
}

if (is_object($this->resultado)){
        return ($this->resultado->rowCount() > 0);
    }
    return $this->resultado;

}


    /**
     * devuelve el resultado de la consulta en formato
     * de objeto.
     *
     * @param $cls (optativo, valor por defecto stdClass)
     * @return
     */
    /*
public function getObject($cls = "StdClass"){
    if (is_null($this->resultado)) {
        return null;
    }

    return $this->resultado->fetchAll($cls) ; // saca una linea de lo devuelto en la DB?¿?
        /// probar print r con cls
 //   print_r($this->resultado);
} */
    public function getObject($cls = "StdClass")
    {
        if (is_null($this->resultado)) return null ;

        // si tenemos un resultado, lo devolvemos
      //  while ($this->resultado->fetch()) {
        //echo "-----> $cls<br/><br/>" ;
            return $this->resultado->fetchObject($cls) ;
       // }

    }
    public function getArraid()
    {
        if (is_null($this->resultado)) return null ;

        // si tenemos un resultado, lo devolvemos
        //  while ($this->resultado->fetch()) {
        //echo "-----> $cls<br/><br/>" ;
        return $this->resultado->fetchAll() ;
        // }

    }

public function __wakeup(){
$this->conectar();
}
public function hola(){
    echo "hola que hace";
}


}