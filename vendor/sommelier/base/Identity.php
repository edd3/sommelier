<?php
namespace sommelier\base;

use model\User;

class Identity
{

    private $_user;
    private $_isLogged;
    private $_asAdmin;

    function __construct()
    {
//        App::$debugger->debug($_SESSION);
        if (isset($_SESSION['userId'])) {
            $this->_user = (new User())->select()->where('id=' . $_SESSION['userId'])->q()[0];
            //@TODO CHECK BLOCK VALIDATION
            //IF BLOCKED -> SESSION_END() MOFO
            $this->_isLogged = true;
            $this->_asAdmin = isset($_SESSION['asAdmin']) ? ($_SESSION['asAdmin']) : false;
        } else {
            $this->_user = false;
            $this->_isLogged = false;
            $this->_asAdmin = false;
        }
    }

    function user()
    {
        return $this->_user;
    }

    function isLogged()
    {
        return $this->_isLogged;
    }

    function asAdmin()
    {
        return $this->_asAdmin;
    }
}
