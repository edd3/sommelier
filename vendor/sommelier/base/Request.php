<?php
namespace sommelier\base;

class Request
{

    public $method = '';
    public $path = '';
    public $data = null;

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->path = isset($_SERVER['PATH_INFO']) ? trim($_SERVER['PATH_INFO'], '/') : null;
        $this->data = json_decode(file_get_contents('php://input'));
    }

    public function segment($segment_index, $default = null)
    {
        $segments = explode('/', $this->path);
        if (isset($segments[$segment_index])) {
            return $segments[$segment_index];
        }
        return $default;
    }

    public function segments()
    {
        $segments = explode('/', $this->path);
        return $segments;
    }
}
