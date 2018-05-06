<?php
namespace sommelier\base;

class Exception
{

    function __construct($code, $message = null)
    {
        App::$debug = debug_backtrace();
        if ($code == 404 && $message == null) {
            $message = 'Несъществуваща страничка';
        } elseif ($code == 405) {
            $message = 'Method not allowed';
        }
        throw new \Exception($message, $code);
    }
}
