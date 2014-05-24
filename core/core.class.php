<?php
class Core {

    private $config;
    private $mode;
    private $controller;
    private $action;
    private $url;
    private $request_url;
    private $script_url;
    private $url_segments;

    public function __construct($config){
        // Defaults
        $this->config = $config;
        $this->controller = $this->config['default_controller'];
        $this->action = 'index';
        $this->request_url = (isset($_SERVER['REQUEST_URI'])) ? $_SERVER['REQUEST_URI'] : '';
        $this->script_url  = (isset($_SERVER['PHP_SELF'])) ? $_SERVER['PHP_SELF'] : '';

        // Url path, cleaned
        if($this->request_url != $this->script_url){
            $this->url = $this->getCleanedUrl();
        }

        // Controller and action assignments
        $this->checkAndAssignSegments();

        $this->loadController();

        // Create object and call method
        $obj = new $this->controller;
        $this->mode = $obj->mode;
        if($this->mode == $this->config['base_template_admin']){
            $args = array_slice($this->url_segments, 1, 2);
            $action = isset($args[1]) ? array(array($args[0] => $args[1])) : array();
        }
        else {
            $action = array_slice($this->url_segments, 2, 1);
        }
        die(call_user_func_array(array($obj, $this->action), $action));
    }

    private function getCleanedUrl(){
        $script_url = str_replace('index.php', '', $this->script_url);
        $script_url = str_replace('/', '\/', $script_url);
        $url = preg_replace('/'. $script_url .'/', '', $this->request_url, 1).'/';
        return trim($url);
    }

    private function checkAndAssignSegments(){
        $this->url_segments = explode('/', $this->url);
        $this->controller = isset($this->url_segments[0]) && $this->url_segments[0] != '' ? $this->url_segments[0] : $this->controller;
        $this->action = isset($this->url_segments[1]) && $this->url_segments[1] != '' ? $this->url_segments[1] : $this->action;
    }

    private function loadController(){
        $controller_path = APP_DIR.'controllers/'.$this->controller.'.class.php';

        // Set controller
        if(file_exists($controller_path)){
            require_once($controller_path);
        }
        else {
            $this->controller = $this->config['error_controller'];
            require_once(APP_DIR.'controllers/'.$this->controller . '.class.php');
        }

        if($this->controller == $this->config['base_template_admin']){
            $this->action = 'index';
        }
        // Check the action exists
        if(!method_exists($this->controller, $this->action)){
            $this->controller = $this->config['error_controller'];
            require_once(APP_DIR.'controllers/'.$this->controller.'.class.php');
            $this->action = 'index';
        }
    }

}
