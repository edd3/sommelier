<?php
namespace sommelier\base;

use sommelier\helper\Formatter;
use sommelier\helper\Debugger;

class App
{

    public static $debug;
    public static $view;
    public static $router;
    public static $mainDir;
    public static $db;
    public static $formatter;
    public static $debugger;
    public static $identity;

    public static function before()
    {
        self::$debugger = new Debugger();
        self::$view = new View();
        self::$mainDir = __DIR__ . '/../../../';
        self::$router = new Router();
        self::$formatter = new Formatter();
        self::$identity = new Identity();
    }

    public static function run()
    {

        self::$router->doAction();
    }

    public static function after()
    {
        
    }

    public static function work($config = null)
    {
        try {
            self::$db = new \mysqli($config['db']['host'], $config['db']['username'], $config['db']['password'], $config['db']['database']);
            self::$db->set_charset('utf8');
            if (self::$db->connect_errno) {
                throw new Exception(500, 'Error with the MySql connection: ' . self::$db->connect_errno . self::$db->connect_error);
            }
            self::before();
            self::run();
            self::after();
        } catch (\Exception $e) {//@TODO ADD RESPONSE CODES HERE
            echo $e->getCode(); //@TODO RENDER ERROR PAGE
            echo '<br>';
            if (DEBUG || !(strpos($e->getMessage(), 'MySql error!') !== false)) {//hide mysql error if not debugging and show a simple error
                echo $e->getMessage();
            } else {
                echo 'Database error!';
            }
            echo '<br><br>';
            if (DEBUG) {
                foreach ($e->getTrace() as $k => $v) {
                    echo ($k + 1) . ' : ';
                    var_dump($v['args']);
                    echo '<br>';
                    echo $v['function'] . ' @ ';
                    echo (isset($v['file']) ? $v['file'] : null) . (isset($v['line']) ? (' : ' . $v['line']) : false);
                    echo '<br><br>';
                }
            }
            exit();
        }
    }
}
