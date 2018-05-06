<?php
namespace sommelier\base;

class Controller
{

    public $action;

    function __construct($action)
    {
        $this->action = $action;
    }

    function doAction($action = false)
    {
        if (!$action) {
            $action = $this->action ?: 'index';
        }
        if (method_exists($this, 'action' . $action)) {
            $this->{'action' . $action}();
        } else {
            throw new Exception(404);
        }
    }
}
