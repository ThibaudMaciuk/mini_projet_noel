<?php

require __DIR__ . '/vendor/autoload.php';
use Application\Controller\error_api;

class routing
{

    private $routes;
    public $actualRoute;

    public function __construct($route = "/")
    {
        $this->actualRoute = (substr($route, -1) !== '/') ? $route."/" : $route;

        $this->routes = array(
            "/api/test/" => array("Test", "Index"),
        );
    }


    public function getResponse()
    {

        if ($this->getRoute($this->actualRoute))
        {

            $route = $this->routes[$this->actualRoute];
            
            $Classe = $route[0];
            $Methode = $route[1];

            include_once 'Application/' . $Classe . '.php';

            $instance = new $Classe();

            return call_user_func([$instance, $Methode]);
        }
        else
        {
            return error_api::return_error("500");
        }

    }

    public function getRoute($route) {
            return isset($this->routes[$route]);
    }
}