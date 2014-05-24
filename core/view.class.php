<?php
class View {

    private $my_controller;
    private $mode;
    private $pageVars;
    private $template;
    private $extra_css = array();
    private $extra_js = array();

    public function __construct($template, $mode){
        $this->my_controller = $template;
        $this->mode = $mode;
        $this->template = APP_DIR .'views/'. $template .'.php';
        $this->pageVars = array(
            'title' => '',
            'extra_css' => null,
            'extra_js' => null
        );
    }

    public function set($var, $val){
        $this->pageVars[$var] = $val;
    }

    public function render(){
        global $config;
        extract($this->pageVars);
        ob_start();
        if($this->mode == $config['base_template_admin']){
            require(APP_DIR .'views/components/admin/'.$config['base_template_admin'].'.tpl.php');
        }
        else {
            require(APP_DIR .'views/components/'.$config['base_template'].'.tpl.php');
        }
        echo ob_get_clean();
    }

    private function addCustomFile($type, $file){
        try {
            if(!isset($this->pageVars['static'])){
                throw new Exception('You have to set static var before add custom '.$type.' files in your controller '.$this->my_controller.'.class.php');
            }
            $src = $this->pageVars['static']->{$type}($file);
            $var_name = 'extra_'.$type;
            $tab = sizeof($this->{$var_name}) == 0 ? '' : '    ';
            if($type == 'css'){
                $html = '<link rel="stylesheet" type="text/css" href="'.$src.'">';
            }
            else {
                $html = '<script type="text/javascript" src="'.$src.'"></script>';
            }
            array_push($this->{$var_name}, $tab.$html);
            $this->set($var_name, implode("\n", $this->{$var_name}));
        }
        catch(Exception $e){
            exit($e->getMessage());
        }
    }

    public function addCss($css){
        $this->addCustomFile('css', $css);
    }

    public function addJs($js){
        $this->addCustomFile('js', $js);
    }

    public function content(){
        include($this->template);
    }

}