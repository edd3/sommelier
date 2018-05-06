<?php
namespace sommelier\helper;

use sommelier\base\Exception;
use sommelier\base\App;

class Debugger
{

    public static function debug($var)
    {
        $filename = App::$mainDir . 'logs/debug.log';
        $file = fopen($filename, 'a+');

        $output = App::$formatter->toDateTime(time()) . ' : ';
        ob_start();
        var_dump($var);
        $output .= ob_get_clean() . "\n";

        foreach (debug_backtrace() as $k => $v) {
            $output .= $v['function'] . ' @ ' . $v['file'] . ':' . $v['line'] . ' ' . "\n";
        }
        $output .= "\n";

        fwrite($file, $output);
        fclose($file);
    }
}
