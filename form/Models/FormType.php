<?php

class  FormType extends FModel {
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
    * Will through exception is not unique name.
    *
    * @param string $name Unique name of the form
    *
    * @return integer the form id
    */
   static function create($name)
    {
        //check if this name exists
        $nameCount= FModel::$db->countRecords("form_type", "name = :name", array(":name" => $name));
        
       if($nameCount>0)
       {
           throw new Exception("The FormType name id not unique");
       }
       
       //insert the Form Type
       FModel::$db->insert("form_type", array(
           "name" => $name,
       ));
       
       return FModel::$db->lastInsertId("form_type_id_seq");
    }
    
    
    
    /**
    * @param string $name string or number
    *
    * @return void
    */
    static function delete($name)
    {
        
        if(is_numeric($name)){
            
            //throw exception if there are forms submitted usign this form
            $nameCount= FModel::$db->countRecords("_form_details", "form_type_id = :id", array(":id" => $name));
            if($nameCount>0)
                throw new Exception ("There have been forms created using this form type.");
          
            FModel::$db->delete("form_type", "id = " . $name);
                            
            FModel::$db->display_errors();
        }
        else{
            //throw exception if there are forms submitted using this form
            $nameCount= FModel::$db->countRecords("_form_details", "form_type_name = :name", array(":name" => $name));
            if($nameCount>0)
                throw new Exception ("There have been forms created usign this form type.");

            FModel::$db->delete("form_type", 'name = "' . $name . '"');
        }
    }
    
    /**
    * @param string $name name of the fiels type
    *
    * @return int or -1
    */
    static function getId($name){
       $data =  FModel::$db->select("select id from form_type where name=:name", array(":name"=> $name));
       
       if(isset($data[0]["id"]))
           return $data[0]["id"];
       else 
           return -1;
    }
    
}