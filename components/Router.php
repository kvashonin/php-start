<?php

class Router
{
    private $routes;

    /**
     * Router constructor.
     */
    public function __construct()
    {
        $routesPath = ROOT.'/config/routes.php';
        $this->routes = include($routesPath);
    }

    /**
     * Return request string
     * @return string
     */
    private function getURI()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], "/");
        }
    }

    public function run()
    {
        //получаем текущий запрос
        $uri = $this->getURI();

        //сравниваем запрос с массивом роутов
        foreach ($this->routes as $uriPattern => $path) {

            //если запрос существует в роутах
            if (preg_match("~$uriPattern~", $uri)) {

                //разбиваем строку на контроллер и экшн
                $segment = explode("/", $path);

                $controllerName = ucfirst(array_shift($segment))."Controller";

                $actionName = 'action'.ucfirst(array_shift($segment));

                $controllerFile = ROOT."/controllers/".$controllerName.".php";
                if (file_exists($controllerFile)) {
                    include_once($controllerFile);
                };

                $controllerObject = new $controllerName;
                $result = $controllerObject->$actionName();

                if ($result != null) {
                    break;
                }
             }
        }
    }
}