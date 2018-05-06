<?php
namespace sommelier\base;

class View
{

    public $title;
    public $layout;

    public function __construct()
    {
        $this->layout = 'main';
        $this->title = 'Empty title';
    }

    public function function_get_output($fn)
    {
        $args = func_get_args();
        unset($args[0]);
        ob_start();
        call_user_func_array([$this, $fn], $args);
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }

    public function display($template, $params = array())
    {
        extract($params);
        $layoutFilename = App::$mainDir . 'view/layout/' . $this->layout . '.php';
        $filename = App::$mainDir . 'view/' . $template[1] . '/' . $template[0] . '.php';
        if (file_exists($filename)) {
            if (file_exists($layoutFilename)) {
                include $filename;
            } else {
                throw new Exception(500, 'No layout file found.');
            }
        } else {
            throw new Exception(500, 'No view file found.');
        }
    }

    public function render($template = null, $params = [])
    {

        if (!$template) {
            $template = [App::$router->action, App::$router->controller];
        } else {
            if (!is_array($template)) {
                $template = [$template, App::$router->controller];
            }
        }
        $content = $this->function_get_output('display', $template, $params);

        $main = $this->function_get_output('display', ['main', 'layout'], ['content' => $content]);

        return $main;
    }

    public function renderPartial($template = null, $params = [])
    {

        if (!$template) {
            $template = [App::$router->action, App::$router->controller];
        } else {
            if (!is_array($template)) {
                $template = [$template, App::$router->controller];
            }
        }
        $content = $this->function_get_output('display', $template, $params);
        return $content;
    }
}
