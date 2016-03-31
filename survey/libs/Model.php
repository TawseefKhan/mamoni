<?php

class Model {

    function __construct() {
        $this->db = new Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);
        $this->msg= new Alert();
    }

    function post_redirect(){
    	header("Location: ".$_SERVER["HTTP_REFERER"]); 
    }
    

}