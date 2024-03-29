<?php

class Router
{
    private $routes;

    public function __construct()
    {
        $routesPath = ROOT.'/config/routes.php';
        $this->routes = include($routesPath);
    }

    private function getURI(){
        if(!empty($_SERVER['REQUEST_URI'])){
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }

    public function run(){
        $uri = $this->getURI();

        foreach($this->routes as $uriPatterns => $path){
            if(preg_match("~$uriPatterns~", $uri)){

                //Получение внутреннего пути из внешнего
                $internalRoute = preg_replace("~$uriPatterns~", $path, $uri);

                //get Controller, action and parameters
                $segments = explode('/', $internalRoute);
                $controllerName = ucfirst(array_shift($segments)).'Controller';
                $actionName = 'action'.ucfirst(array_shift($segments));
                $parameters = $segments;

                //include file controller
                $controllerFile = ROOT.'/controllers/'.$controllerName.'.php';
                if(file_exists($controllerFile)){
                    include_once $controllerFile;
                }

                //create object Controller, call action
                $controllerObject = new $controllerName;
                $result = call_user_func_array(array($controllerObject, $actionName), $parameters);
                if($result != null){
                    break;
                }
            }
        }
    }
}