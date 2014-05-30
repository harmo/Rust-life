<?php
class View {

    private $mode;
    private $pageVars;
    private $template;
    private $extra_css = array();
    private $extra_js = array();

    public function __construct($template, $mode){
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

    public function get($var){
        if(isset($this->pageVars[$var])){
            return $this->pageVars[$var];
        }
        return false;
    }

    public function render(){
        global $config;
        extract($this->pageVars);
        ob_start();
        if($this->mode == $config['admin_mode']){
            require(APP_DIR .'views/components/admin/'.$config['base_template_admin'].'.tpl.php');
        }
        else {
            require(APP_DIR .'views/components/'.$config['base_template'].'.tpl.php');
        }
        echo ob_get_clean();
    }

    private function addCustomFile($type, $file, $vendor){
        try {
            if(!isset($this->pageVars['static'])){
                throw new Exception('You have to set static var before add custom '.$type.' files in your controller '.$this->template.'.class.php');
            }
            $src = $this->pageVars['static']->{$type}($file, $vendor);
            $var_name = 'extra_'.$type;
            $tab = sizeof($this->{$var_name}) == 0 ? '' : '    ';
            if($type == 'css'){
                $html = '<link rel="stylesheet" type="text/css" href="/'.BASE_URL.$src.'">';
            }
            else {
                $html = '<script type="text/javascript" src="/'.BASE_URL.$src.'"></script>';
            }
            array_push($this->{$var_name}, $tab.$html);
            $this->set($var_name, implode("\n", $this->{$var_name}));
        }
        catch(Exception $e){
            exit($e->getMessage());
        }
    }

    public function addCss($css, $type='css'){
        $this->addCustomFile('css', $css, $type);
    }

    public function addJs($js, $type='js'){
        $this->addCustomFile('js', $js, $type);
    }

    public function content(){
        extract($this->pageVars);
        include($this->template);
    }

}