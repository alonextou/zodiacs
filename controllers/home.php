<?php

class HomeController extends Controller {

    function __construct() {
        parent::__construct();
    }

    function index($params = null) {

        require 'models/zodiac.php';
        $model = new ZodiacModel();
        
        // Prepare some data...
        $this->view->zodiacs = $model->getAll();

        // Because my parent constructor (libraries/controller.php) created a new object from the View class ( $this->view = new View(); )...
        // and that View class (libraries/view.php) contains a render method, I can reference $this->view and and send the filename argument.
        $this->view->render('home/index');
    }

}
