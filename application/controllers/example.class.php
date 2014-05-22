<?php
class Example extends Controller {

    function __construct(){
        parent::__construct();
    }

    function index(){
        $exampleModel = $this->loadModel('ExampleTest');
        $test = $exampleModel->test();

        $exampleView = $this->loadView('test');
        $exampleView->set('test', $test);
        $exampleView->render();
    }

}