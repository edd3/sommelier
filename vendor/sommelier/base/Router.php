<?php
namespace sommelier\base;

class Router
{

    public $controller;
    public $action;
    public $controllerN;
    public $request;

    function __construct()
    {
        $request = new Request();

        $controllerStr = 'site';
        $actionStr = 'index';

        $this->request = $request;

        if ($request->segment(0)) {//controller
            $controllerStr = $request->segment(0);
            if ($request->segment(1)) {//action
                $actionStr = $request->segment(1);
            }
        }

        $this->controller = $controllerStr;
        $this->action = $actionStr;

        $type = '\\controller\\' . ucfirst($controllerStr) . 'Controller';
        $filename = __DIR__ . '/../../..' . str_replace('\\', '/', $type) . '.php';


        if (file_exists($filename)) {
            $this->controllerN = new $type($actionStr);
        } else {
            throw new Exception(404);
        }
    }

    public function doAction()
    {
        $this->controllerN->doAction();
    }

    public function redirect($l)
    {
        header('Location: ' . $l);
        die();
    }
}
