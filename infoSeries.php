<?php
require_once("./Database.php");

class infoSeries


{

    private $idSe;
    private $descripcion;
    private $duracion;
    private $emitiendo;
    private $episodios;
    private $estado;
    private $fec_ini;
    private $fec_fin;
    private $img;
    private $pegi;
    private $tipo;
    private $titulo;
    private $tituloJap;
    private $trailer;
    private $idEst;

    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getIdSerie()
    {
        return $this->idSe;
    }

    /**
     * @return mixed
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * @return mixed
     */
    public function getDuracion()
    {
        return $this->duracion;
    }

    /**
     * @return mixed
     */
    public function getEmitiendo()
    {
        return $this->emitiendo;
    }

    /**
     * @return mixed
     */
    public function getEpisodios()
    {
        return $this->episodios;
    }

    /**
     * @return mixed
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * @return mixed
     */
    public function getFecIni()
    {
        return $this->fec_ini;
    }

    /**
     * @return mixed
     */
    public function getFecFin()
    {
        return $this->fec_fin;
    }

    /**
     * @return mixed
     */
    public function getImg()
    {
        return $this->img;
    }

    /**
     * @return mixed
     */
    public function getPegi()
    {
        return $this->pegi;
    }

    /**
     * @return mixed
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @return mixed
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * @return mixed
     */
    public function getTituloJap()
    {
        return $this->tituloJap;
    }

    /**
     * @return mixed
     */
    public function getTrailer()
    {
        return $this->trailer;
    }

    /**
     * @return mixed
     */
    public function getIdEst()
    {
        return $this->idEst;
    }



}