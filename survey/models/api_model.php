<?php

class api_model extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function callFin(){
    	return $this->db->call("fin6", array("Tawsdsdsdsfdfdasdkhkjh asadfs fsdf",Database::PARAMOUT));
    }
    
    

}