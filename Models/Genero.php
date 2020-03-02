<?php

require_once "./libs/Database.php";
class Genero
{
    private $IdGen;
    private $Genero;

    public static function generos($id){
    $db = new Database();
    $db->query("SELECT * FROM generos WHERE idGen IN (SELECT IdGen FROM `sergen` WHERE idSe = $id) ");
    return $db->getObject("Genero");
    }

    /**
     * @return mixed
     */
    public function getIdGen()
    {
        return $this->IdGen;
    }

    /**
     * @param mixed $IdGen
     */
    public function setIdGen($IdGen): void
    {
        $this->IdGen = $IdGen;
    }

    /**
     * @return mixed
     */
    public function getGenero()
    {
        return $this->Genero;
    }

    /**
     * @param mixed $Genero
     */
    public function setGenero($Genero): void
    {
        $this->Genero = $Genero;
    }



}