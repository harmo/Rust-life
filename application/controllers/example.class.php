<?php
class Example extends Controller {

    function __construct(){
        parent::__construct();
    }

    function index(){
        $example = $this->loadModel('ExampleTest');
        var_dump($example->test());
    }

}