<?php

require_once "./libs/Database.php";
class Estudio
{
    private $idEst;
    private $NombreEstudio;

    public static function buscaEst($id){
        $db = new Database();
        $db->query("SELECT NombreEstudio FROM estudio where idEst = $id");

        return $db->getObject("Estudio");

    }

    /**
     * @return mixed
     */
    public function getIdEst()
    {
        return $this->idEst;
    }

    /**
     * @param mixed $idEst
     */
    public function setIdEst($idEst): void
    {
        $this->idEst = $idEst;
    }

    /**
     * @return mixed
     */
    public function getNombreEstudio()
    {
        return $this->NombreEstudio;
    }

    /**
     * @param mixed $NombreEstudio
     */
    public function setNombreEstudio($NombreEstudio): void
    {
        $this->NombreEstudio = $NombreEstudio;
    }



}