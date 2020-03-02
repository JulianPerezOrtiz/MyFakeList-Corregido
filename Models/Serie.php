<?php

require_once "./libs/Database.php";
class Serie
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

public static function capsAle(){
    $db = new Database();
    $db->query("SELECT * FROM serie ORDER BY rand() LIMIT 4");
    return $db->getObject("Serie") ;

}

public static function bus($txt){
    $db = new Database();
    $db->query("SELECT * FROM serie WHERE titulo like '%$txt%'" );
    return $db->getObject("Serie");
}

public static function serieId($id){
    $db = new Database();
    $db->query("SELECT * FROM serie WHERE idSe = $id");
    return $db->getObject("Serie");
}

public static function relacionados($id){
    $db = new Database();
    $db->query("SELECT * FROM relacionados WHERE idSe = $id");
    return $db->getArraid();
}
public static function compruebaSerUsu($idUsu,$idSer){
    $db = new Database();
    if ($db->query("SELECT * FROM ususer WHERE id_usu = $idUsu AND idSe = $idSer")){
        return $db->getArraid();
    } else {
        return false;
    }



}


public static function seriesRel($id, $tipo){
    $db = new Database();
    $db->query("SELECT * FROM serie WHERE idSe IN (SELECT idRel FROM relacionados WHERE idSe = '$id' AND tipo LIKE '$tipo') ");
    return $db->getObject("Serie");
}

public static function favUsu($idUsu){
    $db = new Database();
    $db->query("SELECT * FROM ususer u INNER JOIN serie s ON u.idSe = s.idSe WHERE u.id_usu = $idUsu AND u.favoritausu = 1");
    return $db->getObject("Serie");
}

public static function lista($idUsuList){
    $db = new Database();
    $db->query("SELECT * FROM ususer u INNER JOIN serie s ON u.idSe = s.idSe WHERE u.id_usu = $idUsuList ORDER BY u.status DESC, s.titulo  ASC");
    return $db->getArraid();
}

public static function upCap($idUsu, $idSe, $CapTo){
    $db = new Database();
    $db->query("SELECT cap, status FROM ususer WHERE id_usu = $idUsu AND idSe = $idSe");
    $capBD = $db->getArraid();
    $cp = $capBD[0]["cap"];
    $sts = $capBD[0]["status"];
    if ($sts != "Viendo") {
       $db->query("UPDATE ususer SET status = 'Viendo' WHERE id_usu = $idUsu AND idSe = $idSe");
    }
    if ( $cp + 1 <= $CapTo){
        $cp++;
        $db->query("UPDATE ususer SET cap = $cp WHERE id_usu = $idUsu AND idSe = $idSe");
        if ($cp != $CapTo) {
            return $cp;
        }

    } if ($cp == $CapTo) {
        $hoy = getdate();
      //  echo "<pre>".print_r($hoy, true)."</pre>" ;
        if (strlen($hoy["mday"]) == 1){
            $dia = "0".$hoy["mday"];
        } else {
            $dia = $hoy["mday"];
        }
        $ac = $hoy["year"]."-".$hoy["mon"]."-".$dia;
        $db->query("UPDATE ususer SET status = 'Completada' WHERE id_usu = $idUsu AND idSe = $idSe");
        $db->query("UPDATE ususer SET fec_finS = '$ac' WHERE id_usu = $idUsu AND idSe = $idSe");
        return $cp;
    }

}

public static function descripcion($text,$idUsu,$idSe){
    $db = new Database();
    $db->query("UPDATE ususer SET review = '$text' WHERE id_usu = $idUsu AND idSe = $idSe");
}

public static function score($sc, $idUsu,$idSe){
    $db = new Database();
    $db->query("UPDATE ususer SET score = $sc WHERE id_usu = $idUsu AND idSe = $idSe");

}
public static function delSer($idSe,$idUsu){
    $db = new Database();
    $db->query("DELETE FROM ususer WHERE idSe = $idSe AND id_usu = $idUsu ");
}

public static function modSts($text, $idUsu,$idSe){
    $db = new Database();
    $db->query("UPDATE ususer SET status = '$text' WHERE id_usu = $idUsu AND idSe = $idSe");
}

public static function addSer($idUsu,$idSe,$ac){
    $db = new Database();

    $db->query( "INSERT INTO `ususer` (`id_usu`, `idSe`, `cap`, `status`, `score`, `review`, `fec_inic`, `fec_finS`) 
            VALUES ('$idUsu', '$idSe', '0', 'Para_Ver', NULL, NULL, '$ac', NULL) ");

}

public static function fav($fav,$idUsu, $idSe){
    $db = new Database();
    $db->query("UPDATE ususer SET favoritausu = $fav WHERE id_usu = $idUsu AND idSe = $idSe ");


}




    /**
     * @return mixed
     */
    public function getIdSe()
    {
        return $this->idSe;
    }

    /**
     * @param mixed $idSe
     */
    public function setIdSe($idSe)
    {
        $this->idSe = $idSe;
    }

    /**
     * @return mixed
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * @param mixed $descripcion
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    /**
     * @return mixed
     */
    public function getDuracion()
    {
        return $this->duracion;
    }

    /**
     * @param mixed $duracion
     */
    public function setDuracion($duracion)
    {
        $this->duracion = $duracion;
    }

    /**
     * @return mixed
     */
    public function getEmitiendo()
    {
        return $this->emitiendo;
    }

    /**
     * @param mixed $emitiendo
     */
    public function setEmitiendo($emitiendo)
    {
        $this->emitiendo = $emitiendo;
    }

    /**
     * @return mixed
     */
    public function getEpisodios()
    {
        return $this->episodios;
    }

    /**
     * @param mixed $episodios
     */
    public function setEpisodios($episodios)
    {
        $this->episodios = $episodios;
    }

    /**
     * @return mixed
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * @param mixed $estado
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    /**
     * @return mixed
     */
    public function getFecIni()
    {
        return $this->fec_ini;
    }

    /**
     * @param mixed $fec_ini
     */
    public function setFecIni($fec_ini)
    {
        $this->fec_ini = $fec_ini;
    }

    /**
     * @return mixed
     */
    public function getFecFin()
    {
        return $this->fec_fin;
    }

    /**
     * @param mixed $fec_fin
     */
    public function setFecFin($fec_fin)
    {
        $this->fec_fin = $fec_fin;
    }

    /**
     * @return mixed
     */
    public function getImg()
    {
        return $this->img;
    }

    /**
     * @param mixed $img
     */
    public function setImg($img)
    {
        $this->img = $img;
    }

    /**
     * @return mixed
     */
    public function getPegi()
    {
        return $this->pegi;
    }

    /**
     * @param mixed $pegi
     */
    public function setPegi($pegi)
    {
        $this->pegi = $pegi;
    }

    /**
     * @return mixed
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @param mixed $tipo
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }

    /**
     * @return mixed
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * @param mixed $titulo
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
    }

    /**
     * @return mixed
     */
    public function getTituloJap()
    {
        return $this->tituloJap;
    }

    /**
     * @param mixed $tituloJap
     */
    public function setTituloJap($tituloJap)
    {
        $this->tituloJap = $tituloJap;
    }

    /**
     * @return mixed
     */
    public function getTrailer()
    {
        return $this->trailer;
    }

    /**
     * @param mixed $trailer
     */
    public function setTrailer($trailer)
    {
        $this->trailer = $trailer;
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
    public function setIdEst($idEst)
    {
        $this->idEst = $idEst;
    }


}