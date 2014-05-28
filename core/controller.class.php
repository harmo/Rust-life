<?php
class Controller {

    public $config;
    public $mode;

    function __construct($mode = 'user'){
        global $config;
        $this->config = $config;
        $this->mode = $mode;
        $this->autoload();
    }

    /**
     * Load automatically helpers and plugins methods
     * @return None
     */
    private function autoload(){
        try {
            foreach($this->config['autoload'] as $type => $payload){
                if(!is_array($payload)){
                    throw new Exception('payload is not an array');
                }

                $funcName = 'load' . ucfirst( substr($type, 0, -1) );

                foreach($payload as $toLoad){
                    if(!method_exists($this, $funcName)){
                        throw new Exception($funcName.' is not an existant method');
                    }
                    if($type == 'helpers'){
                        $this->$toLoad = call_user_func(array($this, $funcName), $toLoad);
                    }
                    elseif($type == 'plugins'){
                        call_user_func(array($this, $funcName), $toLoad);
                    }
                    else {
                        throw new Exception('Unknown type '.$type);
                    }
                }
            }
        }
        catch(Exception $e){
            exit($e->getMessage());
        }
    }

    public function loadModel($name, $config=null){
        require(APP_DIR .'models/'. strtolower($name) .'.class.php');
        $model = new $name($this->config);
        return $model;
    }

    public function loadView($name){
        $view = new View($name, $this->mode);
        return $view;
    }

    public function loadPlugin($name){
        require(APP_DIR .'plugins/'. strtolower($name) .'.class.php');
    }

    public function loadHelper($name){
        require(APP_DIR .'helpers/'. strtolower($name) .'.class.php');
        $helper = new $name;
        return $helper;
    }

    public function redirect($loc, $from=false){
        header('Location: '.$this->config['base_url'].$loc.($from ? '?from='.$from : ''));
    }

}