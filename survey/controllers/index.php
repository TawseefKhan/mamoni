<?php

class Index extends Controller {

    function __construct() {
        parent::__construct();
    }
    
    function index() {
        $fields["title"]="Custom_title";

        echo "<h1 style='text-align:center;'>WELCOME</h1>";
        //$this->view->render('index/index', $fields);
        //$this->view->render('inc/footer', $fields);

        var_dump(FormRepository::get(102));
        
    }
    
    
}