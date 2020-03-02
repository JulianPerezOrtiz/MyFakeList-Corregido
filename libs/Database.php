<?php


class Database
{

    private $pdo ;
    private $res ;


    public function __construct()
    {
        global $data ;
        $this->pdo = new PDO("mysql:host=localhost;dbname=myanimelistV2;charset=utf8","root","")
        or die("Error al conectarse a la BD.") ;
    }
    public function __destruct()
    {
        $this->pdo = null ;
    }
    public function query($sql):bool
    {
        $this->res = $this->pdo->query($sql) ;
        if (is_object($this->res)){
            return ($this->res->rowCount() > 0);
        }
        return $this->res = false;
    }

    public function getObject($cls = "StdClass")
    {
        $data = [] ;
        while($obj = $this->res->fetchObject($cls))
            array_push($data, $obj) ;
        return $data;
    }
    public function getArraid()
    {
        if (is_null($this->res)) return null ;

        return $this->res->fetchAll() ;

    }

}

