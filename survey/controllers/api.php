<?php

class Api extends Controller {

    function __construct() {
        parent::__construct();
    }
    
    function index(){
        //$this->reset();
        //$this->del();
    }
    
    function delete(){
        //$this->reset();
        if(isset($_GET["pass"]))
            if($_GET["pass"]=="mazharul_islam")
                $this->del();
    }
    
    function sync() {        
        
       RequestValidate::validateSyncRequest();
        //the logged in user credentials
        $user  = Authentication::login($_POST["data"]["username"], $_POST["data"]["password"]);
        
        //sent the valid request to model
        $syncRequest = new SyncRequest();
        if((isset($_POST["data"]["get_all"]))&&($_POST["data"]["get_all"]=="true"))
            $syncRequest->run($user, "0", $_POST["data"]["get_all"]);
        else
             $syncRequest->run($user, $_POST["data"]["timestamp"]);
        
        ApiEncode::printJson($syncRequest->getArrays());
         
        //ob_clean();
        //var_dump($_POST["data"]);
    }
    
    function form() {
        RequestValidate::validateFormRequest();
        //the logged in user credentials
        $user  = Authentication::login($_POST["data"]["username"], $_POST["data"]["password"]);
        
        //sent the valid request to model a
        $formRequest = new FormRequest();
        $formRequest->run($user, $_POST["data"]["requests"]);
        ApiEncode::printJson($formRequest->getArrays());
    }
    
    private function del(){
        $db = Database::get();
        $datas = $db->select("select * from forms");
        
        foreach ($datas as $data){
            FormRepository::delete($data["id"]);
        }
    }
    
    private function reset(){
        $datas = array(
            "name" => "dh_antenantals",
            "fields" =>array(
                "patientid" => array(
                    "type" => "number"
                ),
                "bloodpressure" => array(
                    "type" => "bool"
                ),
                "hemoglobintest" => array(
                    "type" => "bool"
                ),
                "urinetest" => array(
                    "type" => "bool"
                ),
                "pregnancyfood" => array(
                    "type" => "bool"
                ),
                "pregnancydanger" => array(
                    "type" => "bool"
                ),
                "fourparts" => array(
                    "type" => "bool"
                ),
                "delivery" => array(
                    "type" => "bool"
                ),
                "feedbaby" => array(
                    "type" => "bool"
                ),
                "sixmonths" => array(
                    "type" => "bool"
                ),
                "familyplanning" => array(
                    "type" => "bool"
                ),
                "folictablet" => array(
                    "type" => "bool"
                ),
                "folictabletimportance" => array(
                    "type" => "bool"
                )
            ),
            "meta" => array(
                "Facility" => "Destrict Hospital"
            )
        );  
        SchemaDefine::create($datas);
    }
    
    function login(){
        RequestValidate::validateLoginRequest();
        //the logged in user credentials
        $user  = Authentication::login($_POST["data"]["username"], $_POST["data"]["password"]);
        
        $r = new Response();
        $r->status = 2;
        $r->message="Correct login and pass";
        
        $arr = $r->getArray();
        $arr["type"] = $user->type;
        
        ApiEncode::printJson($arr);
    }
    
    
}