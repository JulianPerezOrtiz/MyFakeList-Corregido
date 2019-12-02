<?php


class usuario
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

    /**
     * @return mixed
     */
    public function getIdUsu()
    {
        return $this->id_usu;
    }

    /**
     * @return mixed
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * @return mixed
     */
    public function getCorreo()
    {
        return $this->correo;
    }

    /**
     * @return mixed
     */
    public function getContrasenia()
    {
        return $this->contrasenia;
    }

    /**
     * @return mixed
     */
    public function getAvatar()
    {
        return "./avatares/".$this->avatar;
    }

    /**
     * @return mixed
     */
    public function getAbout()
    {
        return $this->about;
    }

    /**
     * @return mixed
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @return mixed
     */
    public function getTipoUsu()
    {
        return $this->tipoUsu;
    }

    /**
     * @return mixed
     */
    public function getFecReg()
    {
        return $this->fec_reg;
    }





}