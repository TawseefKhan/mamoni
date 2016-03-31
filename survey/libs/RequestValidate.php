<?php
class RequestValidate {
    static private function endRequest($msg){
        $r = new Response;
        $r->status=0;
        $r->addMessage($msg);
        ApiEncode::printJson($r->getArray());
        die();
    }

    static function validateFormRequest(){
        if(!isset($_POST["data"])){
            RequestValidate::endRequest("No POST variable with the name of 'data' was found");
        }       
        
        if(is_string($_POST["data"]))
        {
            try{
                $_POST["data"] = (array)json_decode($_POST["data"]);
            } catch (Exception $ex) {
                RequestValidate::endRequest("Invalid Jason String");
            }
        }
        
        if(!isset($_POST["data"]["username"])){
            RequestValidate::endRequest("session_id is required");
        }
        
        if(!isset($_POST["data"]["password"])){
            RequestValidate::endRequest("session_id is required");
        }
        
        if(!isset($_POST["data"]["requests"])){
            RequestValidate::endRequest("No requests available");
        }
    }
    
    static function validateSyncRequest(){ 
       
   
        if(!isset($_POST["data"])){
            RequestValidate::endRequest("No POST variable with the name of 'data' was found");
        }
        
        if(is_string($_POST["data"]))
        {
            try{
                $_POST["data"] = (array)json_decode($_POST["data"]);
            } catch (Exception $ex) {
                RequestValidate::endRequest("Invalid Jason String");
            }
        }
        
        
        if(!isset($_POST["data"]["username"])){
            RequestValidate::endRequest("username is required");
        }
        
        if(!isset($_POST["data"]["password"])){
            RequestValidate::endRequest("password is required");
        }
        
        if(!isset($_POST["data"]["timestamp"])){
            if(!((isset($_POST["data"]["get_all"]))&&($_POST["data"]["get_all"]==true)))
                RequestValidate::endRequest("No timestamp");
        }
        elseif(!Helper::validateDate($_POST["data"]["timestamp"])){
            RequestValidate::endRequest("Please enter a correct timestamp format in the format of 'Y-m-d H:i:s' ");
        }
        
    }
    
    static function validateLoginRequest(){ 
       
   
        if(!isset($_POST["data"])){
            RequestValidate::endRequest("No POST variable with the name of 'data' was found");
        }
        
        if(is_string($_POST["data"]))
        {
            try{
                $_POST["data"] = (array)json_decode($_POST["data"]);
            } catch (Exception $ex) {
                RequestValidate::endRequest("Invalid Jason String");
            }
        }
        
        
        if(!isset($_POST["data"]["username"])){
            RequestValidate::endRequest("username is required");
        }
        
        if(!isset($_POST["data"]["password"])){
            RequestValidate::endRequest("password is required");
        }
        
    }
    
    static function validateSubFormRequest($request){
        
        if(!isset($request["type"])){
            throw new Exception("Request type not found");
        }
        if(!in_array($request["type"], array("add", "update", "delete"))){
            throw new Exception("Invalid request type");
        }
        if(($request["type"]=="add")&&(!isset($request["form_type"]))){
            throw new Exception("Form type not found");
        }
        if(($request["type"]!="add")&&(!isset($request["form_id"]))){
            throw new Exception("Please provide the form Id");
        }
        if(!isset($request["data"])){
            //create empty data or field set
            $request["data"]  = array();
        }
        
        //when updating make sure that the previous timestamp is sent
        
        //remove meta if collector
        //remove data if supervisor
        
    }
    
}
