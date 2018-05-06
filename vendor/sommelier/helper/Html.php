<?php
namespace sommelier\helper;

use sommelier\base\App;

class Html
{

    public static function createMenu($arr)
    {
        return App::$view->renderPartial(['_menu', 'site'], ['arr' => $arr]);
    }

    public static function a($title, $link, $options = [])//@TODO OPTIONS
    {
        return '<a href="' . $link . '">' . $title . '</a>';
    }

    public static function pagination()
    {
        
    }
}
