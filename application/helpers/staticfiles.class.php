<?php
class StaticFiles {

    private $config;

    public function __construct(){
        global $config;
        $this->config = $config;
    }

    public function css($filename, $type='css'){
        return $this->checkFile($filename, 'css', $type);
    }

    public function js($filename, $type='js'){
        return $this->checkFile($filename, 'js', $type);
    }

    public function img($filename){
        return $this->checkFile($filename, null, 'images');
    }

    private function checkFile($filename, $ext, $type){
        try {
            $file = 'static/'.$type.'/'.$filename.'.'.$ext;
            $filepath = ROOT_DIR.$file;
            if(!is_file($filepath)){
                throw new Exception('Unable to find static file '.$filepath);
            }
            return $file;
        }
        catch(Exception $e){
            exit($e->getMessage());
        }
    }

}