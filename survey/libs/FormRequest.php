<?php

class FormRequest extends Response {
    
    public function __construct(){
        $this->errorCount=0;
        $this->db = Database::get(); 
        $this->responses= array();
    }   
    
    /**
    * @var Database $db 
    */
    private $db;
    
    /*
     * @var int $errorCount
     */
    public $errorCount;
    
    /*
     * @var arrayResponse $responses
     */
    public $responses;
    
    public function run($user, $requests){
        $this->status = 2;
        $this->errorCount=0;
        
        
        foreach ($requests as $request) {
            $request = (array)$request;
            
            
            //check the request
            try {
                RequestValidate::validateSubFormRequest($request);
                $request = CastRequest::Cast($user, $request);
                Authentication::AuthenticateFormRequest($user, $request);
            } catch (Exception $exc) {
                $r = new Response();
                $r->status=2;
                $r->addMessage($exc->getMessage());
                $this->responses[]=$r;
                
                $this->errorCount = $this->errorCount + 1;
                
                $this->status = 1;
                
                continue;
            }

            //is add, update or delete
            if($request["type"]=="add"){
                    $r = $this->add($user->id, $request["form_type"], $request["data"], $request["form_id"]);
            }
            elseif($request["type"]=="update"){  
                if(!isset($request["data"])){
                    $request["data"]= array();
                }
                
                if(!isset($request["status"])){
                    $request["status"]=4;
                }
                
                
                if(isset($request["meta"]))
                {
                    var_dump($request["meta"]);
                    $r = $this->update($user->id, $request["form_id"], $request["data"], $request["status"], $request["meta"]);
                }
                else
                    $r = $this->update($user->id, $request["form_id"], $request["data"]);
            }
            elseif($request["type"]=="delete"){
                $r = $this->delete($user->id, $request["form_id"]);
            }
            $this->responses[]=$r;            
        }
        
        //set the final message
        if($this->errorCount==0)
        {
            $this->message="All requests have been sucessfull";
        }
        else{
            $this->message="There maybe a few errors in the request list";
        }
    }
    
    private function add($user_id, $form_type, $data, $local_id, $status=3,  $meta=false ){
        $now = date('Y-m-d H:i:s');
        
        //add to the schema and get the new id   
        try {
            $form_id = FormRepository::add($form_type, $data, $meta);
        } catch (Exception $exc) {
            $r = new Response();
            $r->status = 1;
            $r->addMessage($exc->getMessage());
            $this->errorCount++;
            $this->status = 1;
            return $r;
        }

        
        //add to the sync table
        $check = $this->db->insert("sync", array(
            "_form_id" =>$form_id,
            "timestamp" => $now,
            "_user_id" => $user_id,
            "_update_user_id" => $user_id,
            "local_id" =>  $local_id,
            "status" => $status
        ));
        
        
        //check and send the respose back
        if($check){
            $r = new Response();
            $r->status = 2;
            $r->timestamp = $now;
            $r->addMessage("Added sucessfully");
            //$r->data["form_id"] = $form_id;
            return $r;
        }
        else{
            $r = new Response();
            $r->status = 0;
            $r->addMessage("There was an error when inputting the sync table.");
             $this->errorCount++;
             $this->status = 1;
            return $r;
        }
    }
    
    private function update($user_id, $form_id, $data, $status=4, $meta=false){
        //update the form
        try {
            FormRepository::update($form_id, $data, $meta);
        } catch (Exception $exc) {
            $r = new Response();
            $r->status = 0;
            $r->addMessage($exc->getMessage());
            $this->errorCount++;
            return $r;
        }
        
        //Update to the sync table
        if($status===false)
        {
            $check = $this->db->update("sync", array(
                "timestamp" => date('Y-m-d H:i:s'),
                "_update_user_id" => $user_id
            ), "_form_id = " . $form_id);
        }else{
            $check = $this->db->update("sync", array(
                "timestamp" => date('Y-m-d H:i:s'),
                "_update_user_id" => $user_id,
                "status" => $status
            ), "_form_id = " . $form_id);
        }
        
        
        //check and send the respose back
        if($check){
            $r = new Response();
            $r->status = 2;
            $r->addMessage("Changed sucessfully");
            return $r;
        }
        else{
            $r = new Response();
            $r->status = 0;
            $r->addMessage("There was an error when changing the sync table.");
            $this->errorCount++;
            return $r;
        }
    }
    
    private function delete($user_id, $form_id){
        FormRepository::delete($form_id);
        
        //delete the sync by making status disable
        $check = $this->db->update("sync", array(
            "timestamp" => date('Y-m-d H:i:s'),
            "_update_user_id" => $user_id,
            "status" => false
        ), "_form_id = " . $form_id);
        
         //check and send the respose back
        if($check){
            $r = new Response();
            $r->status = 2;
            $r->addMessage("Form Deleted");
            return $r;
        }
        else{
            $r = new Response();
            $r->status = 0;
            $r->addMessage("There was an error when changing the sync table.");
            $this->errorCount++;
            return $r;
        }
    }
    
    public function getArrays(){
        $arr = $this->getArray();
        $arr["errorCount"] = $this->errorCount;
        
        $arr["responses"] = array();
        
        foreach($this->responses as $response){
            $arr["responses"][] = $response->getArray();
        }
        
        return $arr;
        
    }
}
