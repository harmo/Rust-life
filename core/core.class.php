<?php
class Core {

    public $config;
    private $url;
    private $request_url;
    private $script_url;
    private $url_segments;
    public $action;
    public $params;
    public $controller;
    public $mode;

    public function __construct($config){
        $this->config = $config;
        $this->action = 'index';
        $this->params = array();
        $this->mode = 'user';
        $this->request_url = (isset($_SERVER['REQUEST_URI'])) ? $_SERVER['REQUEST_URI'] : '';
        $this->script_url  = (isset($_SERVER['PHP_SELF'])) ? $_SERVER['PHP_SELF'] : '';

        if($this->request_url != $this->script_url){
            $this->url = $this->getCleanedUrl();
        }

        $this->checkAndAssignSegments();

        $this->loadController();

        $obj = new $this->controller($this);
        die(call_user_func_array(array($obj, $this->action), $this->params));
    }

    private function getCleanedUrl(){
        $script_url = str_replace('index.php', '', $this->script_url);
        $script_url = str_replace('/', '\/', $script_url);
        $url = preg_replace('/'. $script_url .'/', '', $this->request_url, 1);
        return trim($url);
    }

    private function checkAndAssignSegments(){
        $this->mode = isset($_GET['action']) && $_GET['action'] == $this->config['admin_mode'] ? 'admin' : $this->mode;
        if(isset($_GET['params'])){
            $params = explode('/', $_GET['params']);
            if($this->mode == $this->config['admin_mode']){
                if(sizeof($params) > 0 && $params[0] != ''){
                    $this->controller = array_shift($params);
                }
                else {
                    $this->controller = $this->config['default_admin_controller'];
                }
            }
            elseif($_GET['action'] != ''){
                $this->controller = $_GET['action'];
            }
            else {
                $this->controller = $this->config['default_controller'];
            }
            $this->params = $params;
        }
    }

    private function loadController(){
        if($this->mode == 'user'){
            $controller_path = APP_DIR.'controllers/'.$this->controller.'.class.php';
        }
        else {
            $controller_path = APP_DIR.'controllers/'.$this->config['admin_mode'].'/'.$this->controller.'.class.php';
        }

        //var_dump($controller_path);

        if(file_exists($controller_path)){
            require_once($controller_path);
        }
        else {
            $this->controller = $this->config['error_controller'];
            require_once(APP_DIR.'controllers/'.$this->controller . '.class.php');
        }

        // Check the action exists
        if(!method_exists($this->controller, $this->action)){
            $this->controller = $this->config['error_controller'];
            require_once(APP_DIR.'controllers/'.$this->controller.'.class.php');
            $this->action = 'index';
        }
    }
}