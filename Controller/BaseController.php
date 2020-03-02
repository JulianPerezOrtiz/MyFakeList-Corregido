<?php

require_once "vendor/autoload.php" ;
class BaseController
{
    protected $twig;

    public function __construct()
    {
        $loader = new \Twig\Loader\FilesystemLoader("./Views");

        $this->twig = New \Twig\Environment($loader);
    }
}