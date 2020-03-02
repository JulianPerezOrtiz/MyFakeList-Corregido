<?php

require_once "./libs/Database.php";
class Usuario
{
    private $id_usu;
    private $alias;
    private $correo;
    private $contrasenia;
    private $avatar;
    private $about;
    private $location;
    private $tipoUsu;
    private $fec_reg;

    public static function bus($txt){
        $db = New Database();
        $db->query("SELECT * FROM usuario WHERE alias like '%$txt%' ");
           return $db->getObject("Usuario");

    }
    public static function subeFoto($photo,$id){
        $db = new Database();
        $db->query("UPDATE usuario SET avatar ='$photo' WHERE id_usu =  $id" );
        return;
    }
    public static function actuPer($ope,$text,$idUsu){
        $db = new Database();
        $db->query("UPDATE usuario SET $ope = '$text' WHERE id_usu = $idUsu");
        return;
    }
    public static function busUsu($id){
        $db = new Database();
        $db->query("SELECT * FROM usuario where id_usu = $id");
        return $db->getObject("Usuario");
    }
    public static function registro($nick, $correo,$contrasenia,$ac){
        $db = new Database();
       if ($db->query("INSERT INTO `usuario` (`id_usu`, `alias`, `correo`, `contrasenia`, `avatar`, `about`, `location`, `tipoUsu`, `fec_reg`) 
            VALUES (NULL, '$nick', '$correo', '$contrasenia', 'default.jpg', NULL, NULL, NULL, '$ac')")){
           return true;
       }  else{
           return false;
       }
    }
    public static function conNick($txt){
        $db = new Database();
        return  $db->query("SELECT * FROM usuario WHERE alias LIKE '$txt'");
    }
    public static function comMail($txt){
        $db = new Database();
        return  $db->query("SELECT * FROM usuario WHERE correo LIKE '$txt'");
    }


    /**
     * @return mixed
     */
    public function getIdUsu()
    {
        return $this->id_usu;
    }

    /**
     * @param mixed $id_usu
     */
    public function setIdUsu($id_usu): void
    {
        $this->id_usu = $id_usu;
    }

    /**
     * @return mixed
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * @param mixed $alias
     */
    public function setAlias($alias): void
    {
        $this->alias = $alias;
    }

    /**
     * @return mixed
     */
    public function getCorreo()
    {
        return $this->correo;
    }

    /**
     * @param mixed $correo
     */
    public function setCorreo($correo): void
    {
        $this->correo = $correo;
    }

    /**
     * @return mixed
     */
    public function getContrasenia()
    {
        return $this->contrasenia;
    }

    /**
     * @param mixed $contrasenia
     */
    public function setContrasenia($contrasenia): void
    {
        $this->contrasenia = $contrasenia;
    }

    /**
     * @return mixed
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @param mixed $avatar
     */
    public function setAvatar($avatar): void
    {
        $this->avatar = $avatar;
    }

    /**
     * @return mixed
     */
    public function getAbout()
    {
        return $this->about;
    }

    /**
     * @param mixed $about
     */
    public function setAbout($about): void
    {
        $this->about = $about;
    }

    /**
     * @return mixed
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param mixed $location
     */
    public function setLocation($location): void
    {
        $this->location = $location;
    }

    /**
     * @return mixed
     */
    public function getTipoUsu()
    {
        return $this->tipoUsu;
    }

    /**
     * @param mixed $tipoUsu
     */
    public function setTipoUsu($tipoUsu): void
    {
        $this->tipoUsu = $tipoUsu;
    }

    /**
     * @return mixed
     */
    public function getFecReg()
    {
        return $this->fec_reg;
    }

    /**
     * @param mixed $fec_reg
     */
    public function setFecReg($fec_reg): void
    {
        $this->fec_reg = $fec_reg;
    }



}